<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\HTTP\ResponseInterface;

class Repository extends BaseController
{
    private function currentUser(): ?array
    {
        $id = (int) (
            session()->get('user_id')
            ?: session()->get('id')
        );

        if ($id <= 0) {
            return null;
        }

        $db = Database::connect();

        $user = $db->table('users')
            ->select('users.id, users.name, users.sub_wilayah_id,
                      users.is_active, roles.name AS role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $id)
            ->get()
            ->getRowArray();

        if (!$user || (int) $user['is_active'] !== 1) {
            return null;
        }

        if (!in_array($user['role_name'], ['Admin', 'Koordinator'], true)) {
            return null;
        }

        if (
            $user['role_name'] === 'Koordinator'
            && empty($user['sub_wilayah_id'])
        ) {
            return null;
        }

        return $user;
    }

    private function storagePath(): string
    {
        return WRITEPATH . 'uploads/repository/';
    }

    public function index()
    {
        $user = $this->currentUser();

        if (!$user) {
            return redirect()->to(site_url('login'));
        }

        $db = Database::connect();
        $isAdmin = $user['role_name'] === 'Admin';

        $query = $db->table('repository_files rf')
            ->select(
                'rf.*, sw.name AS wilayah_name,
                 u.name AS uploader_name,
                 ms.tahun, ms.nomor AS masa_sidang_nomor,
                 ss.title AS sop_title'
            )
            ->join('sub_wilayah sw', 'sw.id = rf.sub_wilayah_id')
            ->join('users u', 'u.id = rf.uploaded_by')
            ->join('masa_sidang ms', 'ms.id = rf.masa_sidang_id')
            ->join('sop_steps ss', 'ss.id = rf.sop_step_id', 'left');

        if (!$isAdmin) {
            $query->where(
                'rf.sub_wilayah_id',
                (int) $user['sub_wilayah_id']
            );
        }

        $tahun = (int) $this->request->getGet('tahun');
        $wilayah = (int) $this->request->getGet('sub_wilayah');
        $masaSidang = (int) $this->request->getGet('masa_sidang');
        $keyword = trim((string) $this->request->getGet('q'));
        
$kategori = trim((string) $this->request->getGet('kategori'));
$sopStepId = (int) $this->request->getGet('sop_step_id');

$kategoriValid = [
    'Reses',
    'Isu Strategis',
    'Bukti Dukung SOP',
    'Dokumen Kegiatan',
    'Lainnya',
];

if (in_array($kategori, $kategoriValid, true)) {
    $query->where('rf.kategori', $kategori);
}

if ($sopStepId > 0) {
    $query->where('rf.sop_step_id', $sopStepId);
}


        if ($tahun > 0) {
            $query->where('ms.tahun', $tahun);
        }

        if ($masaSidang >= 1 && $masaSidang <= 5) {
            $query->where('ms.nomor', $masaSidang);
        }

        if ($isAdmin && $wilayah > 0) {
            $query->where('rf.sub_wilayah_id', $wilayah);
        }

        if ($keyword !== '') {
            $query->groupStart()
                ->like('rf.original_name', $keyword)
                ->orLike('rf.kategori', $keyword)
                ->orLike('u.name', $keyword)
                ->groupEnd();
        }

        $files = $query
            ->orderBy('rf.created_at', 'DESC')
            ->orderBy('rf.id', 'DESC')
            ->limit(200)
            ->get()
            ->getResultArray();

        return view('repository/index', [
            'title' => 'Knowledge Repository',
            'user' => $user,
            'isAdmin' => $isAdmin,
            'files' => $files,
            'wilayahList' => $db->table('sub_wilayah')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray(),
            'periodeList' => $db->table('masa_sidang')
                ->orderBy('tahun', 'ASC')
                ->orderBy('nomor', 'ASC')
                ->get()
                ->getResultArray(),
            'sopList' => $db->table('sop_steps')
                ->where('is_active', 1)
                ->orderBy('step_number', 'ASC')
                ->get()
                ->getResultArray(),
        ]);
    }

    public function upload()
    {
        $user = $this->currentUser();

        if (!$user || $user['role_name'] !== 'Koordinator') {
            return $this->response
                ->setStatusCode(403)
                ->setBody('Hanya Koordinator yang dapat mengunggah file.');
        }

        $db = Database::connect();

        $masaSidangId = (int) $this->request->getPost('masa_sidang_id');
        $sopStepId = (int) $this->request->getPost('sop_step_id');
        $tracingStepId = (int) $this->request->getPost('tracing_step_id');

        $kategori = trim((string) $this->request->getPost('kategori'));

        $kategoriValid = [
            'Reses',
            'Isu Strategis',
            'Bukti Dukung SOP',
            'Dokumen Kegiatan',
            'Lainnya',
        ];

        if (!in_array($kategori, $kategoriValid, true)) {
            return redirect()->back()->with('error', 'Kategori tidak valid.');
        }

        if (!$db->table('masa_sidang')->where('id', $masaSidangId)->countAllResults()) {
            return redirect()->back()->with('error', 'Masa Sidang tidak valid.');
        }

        if ($sopStepId > 0) {
            if (!$db->table('sop_steps')
                ->where('id', $sopStepId)
                ->where('is_active', 1)
                ->countAllResults()) {
                return redirect()->back()->with('error', 'SOP tidak valid.');
            }
        }

        if ($tracingStepId > 0) {
            if ($sopStepId <= 0) {
                return redirect()->back()->with('error', 'Pilih SOP terlebih dahulu.');
            }

            if (!$db->table('sop_tracing_steps')
                ->where('id', $tracingStepId)
                ->where('sop_step_id', $sopStepId)
                ->where('is_active', 1)
                ->countAllResults()) {
                return redirect()->back()->with('error', 'Sub-tahapan tidak sesuai SOP.');
            }
        }

        $file = $this->request->getFile('dokumen');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        if ($file->getSize() <= 0 || $file->getSize() > 10 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 10 MB.');
        }

        $allowed = [
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        ];

        $mime = $file->getMimeType();

        if (!isset($allowed[$mime])) {
            return redirect()->back()->with(
                'error',
                'Format file harus PDF, JPG, PNG, DOCX, atau XLSX.'
            );
        }

        $extension = strtolower($file->getClientExtension());

        $extensionValid = [
            'pdf' => ['pdf'],
            'jpg' => ['jpg', 'jpeg'],
            'png' => ['png'],
            'docx' => ['docx'],
            'xlsx' => ['xlsx'],
        ];

        $expectedExtension = $allowed[$mime];

        if (!in_array($extension, $extensionValid[$expectedExtension], true)) {
            return redirect()->back()->with(
                'error',
                'Ekstensi file tidak sesuai dengan jenis dokumen.'
            );
        }

        $path = $this->storagePath();

        if (!is_dir($path) && !mkdir($path, 0750, true) && !is_dir($path)) {
            return redirect()->back()->with('error', 'Folder penyimpanan tidak tersedia.');
        }

        $storedName = bin2hex(random_bytes(20)) . '.' . $expectedExtension;

        try {
            $file->move($path, $storedName);

            $saved = $db->table('repository_files')->insert([
                'sub_wilayah_id' => (int) $user['sub_wilayah_id'],
                'masa_sidang_id' => $masaSidangId,
                'sop_step_id' => $sopStepId ?: null,
                'tracing_step_id' => $tracingStepId ?: null,
                'uploaded_by' => (int) $user['id'],
                'kategori' => $kategori,
                'original_name' => basename($file->getClientName()),
                'stored_name' => $storedName,
                'mime_type' => $mime,
                'file_size' => $file->getSize(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if (!$saved) {
                @unlink($path . $storedName);
                return redirect()->back()->with('error', 'Metadata file gagal disimpan.');
            }

            return redirect()->to(site_url('repository'))
                ->with('success', 'Dokumen berhasil diunggah.');
        } catch (\Throwable $e) {
            if (is_file($path . $storedName)) {
                @unlink($path . $storedName);
            }

            log_message('error', 'Repository upload: ' . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'Gagal menyimpan dokumen.'
            );
        }
    }

    public function download($id)
    {
        $user = $this->currentUser();

        if (!$user) {
            return $this->response
                ->setStatusCode(403)
                ->setBody('Akses ditolak.');
        }

        $db = Database::connect();

        $query = $db->table('repository_files')
            ->where('id', (int) $id);

        if ($user['role_name'] !== 'Admin') {
            $query->where(
                'sub_wilayah_id',
                (int) $user['sub_wilayah_id']
            );
        }

        $file = $query->get()->getRowArray();

        if (!$file) {
            return $this->response
                ->setStatusCode(404)
                ->setBody('Dokumen tidak ditemukan.');
        }

        $path = $this->storagePath() . basename($file['stored_name']);

        if (!is_file($path)) {
            return $this->response
                ->setStatusCode(404)
                ->setBody('File fisik tidak ditemukan.');
        }

        $name = str_replace(
            ["\r", "\n", '"', '\\'],
            '',
            $file['original_name']
        );

        return $this->response
            ->download($path, null)
            ->setFileName($name);
    }
    
public function preview($id)
{
    $user = $this->currentUser();

    if (!$user) {
        return $this->response
            ->setStatusCode(403)
            ->setBody('Akses ditolak.');
    }

    $db = \Config\Database::connect();

    $query = $db->table('repository_files')
        ->where('id', (int) $id);

    if ($user['role_name'] !== 'Admin') {
        $query->where(
            'sub_wilayah_id',
            (int) $user['sub_wilayah_id']
        );
    }

    $file = $query->get()->getRowArray();

    if (!$file) {
        return $this->response
            ->setStatusCode(404)
            ->setBody('Dokumen tidak ditemukan.');
    }

    $allowedMime = [
        'application/pdf',
        'image/jpeg',
        'image/png',
    ];

    if (!in_array($file['mime_type'], $allowedMime, true)) {
        return $this->response
            ->setStatusCode(415)
            ->setBody('Format ini tidak mendukung preview.');
    }

    $path = $this->storagePath()
        . basename($file['stored_name']);

    if (!is_file($path)) {
        return $this->response
            ->setStatusCode(404)
            ->setBody('File tidak ditemukan di penyimpanan.');
    }

    $content = file_get_contents($path);

    if ($content === false) {
        return $this->response
            ->setStatusCode(500)
            ->setBody('Dokumen gagal dibaca.');
    }

    return $this->response
        ->setHeader('Content-Type', $file['mime_type'])
        ->setHeader('Content-Disposition', 'inline')
        ->setHeader('X-Content-Type-Options', 'nosniff')
        ->setHeader('Content-Security-Policy', "default-src 'none'; style-src 'unsafe-inline'; sandbox")
        ->setHeader('Cache-Control', 'private, no-store')
        ->setBody($content);
}

}
