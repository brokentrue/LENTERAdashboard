<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class Reses extends BaseController
{
    private function coordinator(): ?array
    {
        $id = (int) (session()->get('user_id') ?: session()->get('id'));
        if (!$id) return null;
        $user = Database::connect()->table('users u')
            ->select('u.id, u.name, u.sub_wilayah_id, u.is_active, r.name AS role_name, sw.name AS wilayah_name')
            ->join('roles r', 'r.id = u.role_id')
            ->join('sub_wilayah sw', 'sw.id = u.sub_wilayah_id', 'left')
            ->where('u.id', $id)->get()->getRowArray();
        return $user && (int) $user['is_active'] === 1
            && $user['role_name'] === 'Koordinator' && (int) $user['sub_wilayah_id'] > 0 ? $user : null;
    }

    private function categories(): array
    {
        return ['Infrastruktur', 'Pendidikan', 'Kesehatan', 'Ekonomi', 'Pemerintahan', 'Sosial', 'Lingkungan', 'Lainnya'];
    }

    public function index()
    {
        $user = $this->coordinator();
        if (!$user) return $this->response->setStatusCode(403)->setBody('Akses hanya untuk Koordinator aktif.');
        $periods = Database::connect()->table('masa_sidang')->orderBy('tahun', 'ASC')->orderBy('nomor', 'ASC')->get()->getResultArray();
        return view('reses/index', [
            'user' => $user, 'periods' => $periods, 'categories' => $this->categories(),
            'tahun' => (int) ($this->request->getGet('tahun') ?: 2026),
            'nomor' => (int) ($this->request->getGet('masa_sidang') ?: 1),
        ]);
    }

    public function store()
    {
        $user = $this->coordinator();
        if (!$user) return $this->response->setStatusCode(403)->setBody('Akses ditolak.');
        $db = Database::connect();
        $periodId = (int) $this->request->getPost('masa_sidang_id');
        if (!$db->table('masa_sidang')->where('id', $periodId)->countAllResults())
            return redirect()->back()->withInput()->with('error', 'Masa Sidang tidak valid.');
        $province = trim((string) $this->request->getPost('provinsi'));
        $issue = trim((string) $this->request->getPost('isu'));
        $description = trim((string) $this->request->getPost('uraian'));
        if ($province === '' || mb_strlen($province) > 100 || !in_array($issue, $this->categories(), true)
            || $description === '' || mb_strlen($description) > 10000)
            return redirect()->back()->withInput()->with('error', 'Provinsi, kategori isu, atau uraian tidak valid.');
        $file = $this->request->getFile('dokumen');
        if (!$file || !$file->isValid() || $file->hasMoved())
            return redirect()->back()->withInput()->with('error', 'File gagal diterima. Periksa ukuran dan formatnya.');
        $maxBytes = 1024 * 1024 * 1024;
        $size = $file->getSize();
        if ($size <= 0 || $size > $maxBytes)
            return redirect()->back()->withInput()->with('error', 'Ukuran file maksimal 1 GB.');
        $allowed = [
            'application/pdf' => ['pdf'],
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => ['docx'],
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => ['xlsx'],
        ];
        $mime = $file->getMimeType();
        $extension = strtolower($file->getClientExtension());
        if (!isset($allowed[$mime]) || !in_array($extension, $allowed[$mime], true))
            return redirect()->back()->withInput()->with('error', 'File harus PDF, DOCX, atau XLSX yang valid.');
        $path = WRITEPATH . 'uploads/repository/';
        if (!is_dir($path) && !mkdir($path, 0750, true) && !is_dir($path))
            return redirect()->back()->with('error', 'Folder penyimpanan tidak tersedia.');
        $stored = bin2hex(random_bytes(20)) . '.' . $extension;
        $moved = false;
        $db->transBegin();
        try {
            if (!$file->move($path, $stored)) throw new \RuntimeException('Pemindahan file gagal.');
            $moved = true;
            $now = date('Y-m-d H:i:s');
            $ok1 = $db->table('aspirasi')->insert([
                'masa_sidang_id' => $periodId,
                'sub_wilayah_id' => (int) $user['sub_wilayah_id'],
                'provinsi' => $province, 'sumber' => 'Reses', 'isu' => $issue,
                'uraian' => $description, 'status' => 'Baru',
                'created_at' => $now, 'updated_at' => $now,
            ]);
            if (!$ok1) throw new \RuntimeException('Penyimpanan aspirasi gagal.');
            $ok2 = $db->table('repository_files')->insert([
                'sub_wilayah_id' => (int) $user['sub_wilayah_id'],
                'masa_sidang_id' => $periodId, 'sop_step_id' => null, 'tracing_step_id' => null,
                'uploaded_by' => (int) $user['id'], 'kategori' => 'Reses',
                'original_name' => basename($file->getClientName()),
                'stored_name' => $stored, 'mime_type' => $mime, 'file_size' => $size,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            if (!$ok2 || $db->transStatus() === false) throw new \RuntimeException('Penyimpanan metadata gagal.');
            $db->transCommit();
            return redirect()->to(site_url('repository') . '?sub_wilayah=' . (int) $user['sub_wilayah_id'])
                ->with('success', 'Hasil Reses dan dokumen berhasil disimpan.');
        } catch (\Throwable $e) {
            $db->transRollback();
            if ($moved && is_file($path . $stored)) @unlink($path . $stored);
            log_message('error', 'Input Reses gagal: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Penyimpanan gagal. Silakan coba lagi.');
        }
    }
}
