<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;

class Progress extends BaseController
{
    private function koordinator(): ?array
    {
        $id = (int) (session()->get('user_id') ?: session()->get('id'));
        if ($id <= 0) return null;
        $user = Database::connect()->table('users u')
            ->select('u.id, u.name, u.sub_wilayah_id, u.is_active, r.name AS role_name')
            ->join('roles r', 'r.id = u.role_id')
            ->where('u.id', $id)->get()->getRowArray();
        if (!$user || (int) $user['is_active'] !== 1 ||
            $user['role_name'] !== 'Koordinator' || empty($user['sub_wilayah_id'])) return null;
        return $user;
    }

    private function periode(int $tahun, int $nomor): ?array
    {
        if (!in_array($tahun, [2026, 2027, 2028, 2029], true) ||
            !in_array($nomor, [1, 2, 3, 4, 5], true)) return null;
        return Database::connect()->table('masa_sidang')
            ->where('tahun', $tahun)->where('nomor', $nomor)
            ->get()->getRowArray();
    }

    public function index()
    {
        return redirect()->to(site_url('dashboard'));
    }

    public function detail($id)
    {
        $user = $this->koordinator();
        if (!$user) return $this->response->setStatusCode(403)->setBody('Akses hanya untuk Koordinator aktif.');

        $tahun = (int) ($this->request->getGet('tahun') ?: 2026);
        $nomor = (int) ($this->request->getGet('masa_sidang') ?: 1);
        $periode = $this->periode($tahun, $nomor);
        if (!$periode) return $this->response->setStatusCode(400)->setBody('Periode tidak valid.');

        $db = Database::connect();
        $sop = $db->table('sop_steps')->where('id', (int) $id)
            ->where('is_active', 1)->get()->getRowArray();
        if (!$sop) throw PageNotFoundException::forPageNotFound('SOP tidak ditemukan.');

        $progress = $db->table('progress')
            ->where('sub_wilayah_id', (int) $user['sub_wilayah_id'])
            ->where('masa_sidang_id', (int) $periode['id'])
            ->where('sop_step_id', (int) $id)->get()->getRowArray();

        $steps = $db->table('sop_tracing_steps sts')
            ->select('sts.id AS tracing_step_id, sts.urutan, sts.nama_proses, sts.deskripsi')
            ->where('sts.sop_step_id', (int) $id)->where('sts.is_active', 1)
            ->orderBy('sts.urutan', 'ASC')->get()->getResultArray();

        $statuses = [];
        if ($progress) {
            $rows = $db->table('progress_tracing')
                ->where('progress_id', (int) $progress['id'])->get()->getResultArray();
            foreach ($rows as $row) $statuses[(int) $row['tracing_step_id']] = $row;
        }

        $completed = 0;
        $processing = 0;
        foreach ($steps as &$step) {
            $row = $statuses[(int) $step['tracing_step_id']] ?? [];
            $step['status'] = $row['status'] ?? 'belum';
            $step['catatan'] = $row['catatan'] ?? '';
            $step['tanggal_update'] = $row['tanggal_update'] ?? null;
            if ($step['status'] === 'selesai') $completed++;
            if ($step['status'] === 'proses') $processing++;
        }
        unset($step);

        return view('progress/detail', [
            'title' => 'Update Progres SOP', 'user' => $user,
            'sop' => $sop, 'progress' => $progress,
            'tracingSteps' => $steps, 'tahun' => $tahun, 'nomor' => $nomor,
            'totalTracing' => count($steps), 'completedTracing' => $completed,
            'processTracing' => $processing,
            'progressPercent' => count($steps) ? round($completed / count($steps) * 100, 1) : 0,
        ]);
    }

    public function update($id)
    {
        $user = $this->koordinator();
        if (!$user) return $this->response->setStatusCode(403)->setBody('Akses ditolak.');

        $tahun = (int) $this->request->getPost('tahun');
        $nomor = (int) $this->request->getPost('masa_sidang');
        $periode = $this->periode($tahun, $nomor);
        if (!$periode) return $this->response->setStatusCode(400)->setBody('Periode tidak valid.');

        $db = Database::connect();
        $sop = $db->table('sop_steps')->where('id', (int) $id)
            ->where('is_active', 1)->get()->getRowArray();
        if (!$sop) throw PageNotFoundException::forPageNotFound('SOP tidak ditemukan.');

        $tracingId = (int) $this->request->getPost('tracing_step_id');
        $tracing = $db->table('sop_tracing_steps')
            ->where('id', $tracingId)->where('sop_step_id', (int) $id)
            ->where('is_active', 1)->get()->getRowArray();
        if (!$tracing) return $this->response->setStatusCode(400)->setBody('Sub-tahapan SOP tidak valid.');

        $status = (string) $this->request->getPost('status');
        $catatan = trim((string) $this->request->getPost('catatan'));
        if (!in_array($status, ['belum', 'proses', 'selesai'], true) || mb_strlen($catatan) > 2000) {
            return redirect()->back()->with('error', 'Status atau panjang catatan tidak valid.');
        }

        $wilayahId = (int) $user['sub_wilayah_id'];
        $periodeId = (int) $periode['id'];
        $now = date('Y-m-d H:i:s');
        $db->transBegin();
        try {
            $progress = $db->table('progress')->where('sub_wilayah_id', $wilayahId)
                ->where('masa_sidang_id', $periodeId)
                ->where('sop_step_id', (int) $id)->get()->getRowArray();
            if (!$progress) {
                $db->table('progress')->insert([
                    'sub_wilayah_id' => $wilayahId, 'masa_sidang_id' => $periodeId,
                    'sop_step_id' => (int) $id, 'status' => 'belum',
                    'created_at' => $now, 'updated_at' => $now,
                ]);
                $progressId = (int) $db->insertID();
            } else {
                $progressId = (int) $progress['id'];
            }

            $existing = $db->table('progress_tracing')->where('progress_id', $progressId)
                ->where('tracing_step_id', $tracingId)->get()->getRowArray();
            $payload = [
                'status' => $status, 'catatan' => $catatan ?: null,
                'tanggal_update' => $now, 'updated_by' => (int) $user['id'],
                'updated_at' => $now,
            ];
            if ($existing) {
                $db->table('progress_tracing')->where('id', (int) $existing['id'])->update($payload);
            } else {
                $db->table('progress_tracing')->insert($payload + [
                    'progress_id' => $progressId, 'tracing_step_id' => $tracingId,
                    'created_at' => $now,
                ]);
            }

            // Ringkasan status SOP mengikuti status seluruh sub-tahapan aktif.
            $all = $db->table('sop_tracing_steps sts')
                ->select('sts.id, pt.status')
                ->join('progress_tracing pt', 'pt.tracing_step_id = sts.id AND pt.progress_id = ' . $progressId, 'left')
                ->where('sts.sop_step_id', (int) $id)->where('sts.is_active', 1)
                ->get()->getResultArray();
            $total = count($all);
            $done = 0;
            $hasProcess = false;
            foreach ($all as $row) {
                if ($row['status'] === 'selesai') $done++;
                if (in_array($row['status'], ['proses', 'selesai'], true)) $hasProcess = true;
            }
            $summary = $total > 0 && $done === $total ? 'selesai' : ($hasProcess ? 'proses' : 'belum');
            $db->table('progress')->where('id', $progressId)->update([
                'status' => $summary, 'updated_by' => (int) $user['id'],
                'tanggal_update' => $now, 'updated_at' => $now,
            ]);

            if ($db->transStatus() === false) throw new \RuntimeException('Transaksi database gagal.');
            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Update progres SOP: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Pembaruan progres gagal disimpan.');
        }

        return redirect()->to(site_url('progress/' . (int) $id) . '?' . http_build_query([
            'tahun' => $tahun, 'masa_sidang' => $nomor,
        ]))->with('success', 'Progres sub-tahapan berhasil diperbarui.');
    }
}
