<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        $session = session();
        $userId = (int) ($session->get('user_id') ?: $session->get('id'));

        if ($userId <= 0) {
            return redirect()->to(site_url('login'));
        }

        $user = $db->table('users')
            ->select('users.id, users.name, users.is_active, users.sub_wilayah_id,
                      roles.name AS role_name, sub_wilayah.name AS wilayah_name')
            ->join('roles', 'roles.id = users.role_id')
            ->join('sub_wilayah', 'sub_wilayah.id = users.sub_wilayah_id', 'left')
            ->where('users.id', $userId)
            ->get()->getRowArray();

        if (!$user || (int) $user['is_active'] !== 1) {
            return service('response')->setStatusCode(403)
                ->setBody('Akun tidak aktif atau tidak ditemukan.');
        }

        $isAdmin = $user['role_name'] === 'Admin';
        $isKoordinator = $user['role_name'] === 'Koordinator';
        if (!$isAdmin && !$isKoordinator) {
            return service('response')->setStatusCode(403)
                ->setBody('Akun belum memiliki akses dashboard.');
        }
        if ($isKoordinator && empty($user['sub_wilayah_id'])) {
            return service('response')->setStatusCode(403)
                ->setBody('Sub Wilayah belum ditetapkan oleh Admin.');
        }

        $tahunList = [2026, 2027, 2028, 2029];
        $nomorMasaSidang = [1, 2, 3, 4, 5];
        $tahun = (int) ($this->request->getGet('tahun') ?: 2026);
        $nomor = (int) ($this->request->getGet('masa_sidang') ?: 1);
        if (!in_array($tahun, $tahunList, true)
            || !in_array($nomor, $nomorMasaSidang, true)) {
            return service('response')->setStatusCode(400)
                ->setBody('Periode tidak valid.');
        }

        $periode = $db->table('masa_sidang')
            ->where('tahun', $tahun)->where('nomor', $nomor)
            ->get()->getRowArray();
        $masaSidangId = $periode ? (int) $periode['id'] : null;

        $subWilayahList = $db->table('sub_wilayah')
            ->orderBy('id', 'ASC')->get()->getResultArray();
        $subWilayahId = $isKoordinator
            ? (int) $user['sub_wilayah_id']
            : (int) $this->request->getGet('sub_wilayah');
        $subWilayahId = $subWilayahId > 0 ? $subWilayahId : null;

        if ($subWilayahId !== null) {
            $validIds = array_map(
                static fn ($row) => (int) $row['id'], $subWilayahList
            );
            if (!in_array($subWilayahId, $validIds, true)) {
                return service('response')->setStatusCode(400)
                    ->setBody('Sub Wilayah tidak valid.');
            }
        }

        $scopeAspirasi = static function ($query) use ($masaSidangId, $subWilayahId) {
            if ($masaSidangId === null) {
                $query->where('id', 0);
            } else {
                $query->where('masa_sidang_id', $masaSidangId);
            }
            if ($subWilayahId !== null) {
                $query->where('sub_wilayah_id', $subWilayahId);
            }
            return $query;
        };

        $totalAspirasi = $scopeAspirasi($db->table('aspirasi'))
            ->countAllResults();
        $totalProvinsi = $scopeAspirasi($db->table('aspirasi'))
            ->select('provinsi')->where('provinsi IS NOT NULL', null, false)
            ->where('provinsi !=', '')->groupBy('provinsi')->countAllResults();
        $totalIsu = $scopeAspirasi($db->table('aspirasi'))
            ->select('isu')->where('isu IS NOT NULL', null, false)
            ->where('isu !=', '')->groupBy('isu')->countAllResults();
        $topicRows = $scopeAspirasi($db->table('aspirasi'))
            ->select('isu, COUNT(*) AS total')
            ->where('isu IS NOT NULL', null, false)
            ->where('isu !=', '')->groupBy('isu')
            ->orderBy('total', 'DESC')->limit(5)->get()->getResultArray();
        $topics = [];
        foreach ($topicRows as $topic) {
            $topics[] = [
                'name' => $topic['isu'],
                'total' => (int) $topic['total'],
                'percent' => $totalAspirasi > 0
                    ? round((int) $topic['total'] / $totalAspirasi * 100, 1)
                    : 0,
            ];
        }

        $sopSteps = $db->table('sop_steps')
            ->where('is_active', 1)->orderBy('step_number', 'ASC')
            ->get()->getResultArray();
        $totalSteps = count($sopSteps);

        $progressScoped = $db->tableExists('progress')
            && $db->tableExists('progress_tracing')
            && $db->tableExists('sop_tracing_steps');

        // Seluruh sub-tahapan aktif diambil sekali dan dikelompokkan per SOP.
        $tracingBySop = [];
        if ($progressScoped) {
            $tracingRows = $db->table('sop_tracing_steps')
                ->where('is_active', 1)
                ->orderBy('sop_step_id', 'ASC')
                ->orderBy('urutan', 'ASC')->get()->getResultArray();
            foreach ($tracingRows as $tracing) {
                $tracingBySop[(int) $tracing['sop_step_id']][] = $tracing;
            }
        }

        // Mengembalikan null jika periode belum memiliki status sub-tahapan.
        // Baris NULL tidak dianggap selesai maupun sebagai aktivitas.
        $calculateProgress = static function (int $wilayahId, int $periodId)
            use ($db, $sopSteps, $tracingBySop, $progressScoped) {
            if (!$progressScoped || !$sopSteps) {
                return null;
            }

            $rows = $db->table('progress p')
                ->select('p.sop_step_id, pt.tracing_step_id, pt.status')
                ->join('progress_tracing pt', 'pt.progress_id = p.id', 'inner')
                ->join('sop_tracing_steps st',
                    'st.id = pt.tracing_step_id AND st.sop_step_id = p.sop_step_id', 'inner')
                ->where('p.sub_wilayah_id', $wilayahId)
                ->where('p.masa_sidang_id', $periodId)
                ->where('st.is_active', 1)
                ->get()->getResultArray();

            $statusByTracing = [];
            $hasActivity = false;
            foreach ($rows as $row) {
                $status = $row['status'];
                $statusByTracing[(int) $row['tracing_step_id']] = $status;
                if (in_array($status, ['belum', 'proses', 'selesai'], true)) {
                    $hasActivity = true;
                }
            }
            if (!$hasActivity) {
                return null;
            }

            $completed = 0;
            $total = 0;
            $stepDetails = [];
            $statuses = [];
            foreach ($sopSteps as $step) {
                $stepId = (int) $step['id'];
                $subSteps = [];
                $stepCompleted = 0;
                foreach ($tracingBySop[$stepId] ?? [] as $tracing) {
                    $tracingId = (int) $tracing['id'];
                    $status = $statusByTracing[$tracingId] ?? 'belum';
                    $subSteps[] = [
                        'id' => $tracingId,
                        'urutan' => (int) $tracing['urutan'],
                        'nama_proses' => $tracing['nama_proses'],
                        'deskripsi' => $tracing['deskripsi'] ?? '',
                        'status' => $status,
                    ];
                    if ($status === 'selesai') {
                        $stepCompleted++;
                    }
                }
                $stepTotal = count($subSteps);
                $completed += $stepCompleted;
                $total += $stepTotal;
                $stepStatus = $stepTotal > 0 && $stepCompleted === $stepTotal
                    ? 'selesai' : ($stepCompleted > 0 ? 'proses' : 'belum');
                $statuses[$stepId] = $stepStatus;
                $stepDetails[$stepId] = [
                    'completed' => $stepCompleted,
                    'total' => $stepTotal,
                    'percent' => $stepTotal > 0
                        ? round($stepCompleted / $stepTotal * 100, 1) : 0,
                    'status' => $stepStatus,
                    'sub_steps' => $subSteps,
                ];
            }
            return [
                'completed' => $completed,
                'total' => $total,
                'percent' => $total > 0 ? round($completed / $total * 100, 1) : 0,
                'statuses' => $statuses,
                'step_details' => $stepDetails,
            ];
        };

        // Empat donut Admin selalu dihitung, sekalipun satu wilayah dipilih.
        $progressPerWilayah = [];
        foreach ($subWilayahList as $wilayah) {
            $wilayahId = (int) $wilayah['id'];
            if ($isKoordinator && $wilayahId !== $subWilayahId) {
                continue;
            }
            $progressPerWilayah[$wilayahId] = $masaSidangId !== null
                ? $calculateProgress($wilayahId, $masaSidangId) : null;
        }
        $progressSaatIni = $subWilayahId !== null
            ? ($progressPerWilayah[$subWilayahId] ?? null) : null;

        // Detail sub-tahapan tersedia walau belum ada catatan progres.
        foreach ($sopSteps as &$step) {
            $stepId = (int) $step['id'];
            $detail = $progressSaatIni['step_details'][$stepId] ?? null;
            $subSteps = $detail['sub_steps'] ?? [];
            if (!$detail) {
                foreach ($tracingBySop[$stepId] ?? [] as $tracing) {
                    $subSteps[] = [
                        'id' => (int) $tracing['id'],
                        'urutan' => (int) $tracing['urutan'],
                        'nama_proses' => $tracing['nama_proses'],
                        'deskripsi' => $tracing['deskripsi'] ?? '',
                        'status' => 'belum',
                    ];
                }
            }
            $step['sub_steps'] = $subSteps;
            $step['completed_sub_steps'] = $detail['completed'] ?? 0;
            $step['total_sub_steps'] = count($subSteps);
            $step['percent'] = $detail['percent'] ?? 0;
            $step['status'] = $detail['status'] ?? 'belum';
        }
        unset($step);

        // Grafik tahunan: rata-rata Masa Sidang yang sudah mempunyai status.
        $grafikTahunan = [];
        foreach ($tahunList as $tahunGrafik) {
            $periodeRows = $db->table('masa_sidang')
                ->where('tahun', $tahunGrafik)->get()->getResultArray();
            $periodIds = [];
            foreach ($periodeRows as $p) {
                $periodIds[(int) $p['nomor']] = (int) $p['id'];
            }
            $series = [];
            foreach ($subWilayahList as $wilayah) {
                $wilayahId = (int) $wilayah['id'];
                if ($isKoordinator && $wilayahId !== $subWilayahId) {
                    continue;
                }
                $nilai = [];
                foreach ($periodIds as $periodId) {
                    $hasil = $calculateProgress($wilayahId, $periodId);
                    if ($hasil !== null) {
                        $nilai[] = $hasil['percent'];
                    }
                }
                $series[$wilayahId] = $nilai
                    ? round(array_sum($nilai) / count($nilai), 1) : null;
            }
            $grafikTahunan[] = ['tahun' => $tahunGrafik, 'series' => $series];
        }

        return view($isAdmin ? 'dashboard/index' : 'dashboard/koordinator', [
            'title' => 'Dashboard LENTERA',
            'user' => $user,
            'isAdmin' => $isAdmin,
            'tahun' => $tahun,
            'nomor' => $nomor,
            'tahunList' => $tahunList,
            'nomorMasaSidang' => $nomorMasaSidang,
            'subWilayahId' => $subWilayahId,
            'subWilayahList' => $subWilayahList,
            'totalAspirasi' => $totalAspirasi,
            'totalProvinsi' => $totalProvinsi,
            'totalIsu' => $totalIsu,
            'topics' => $topics,
            'sopSteps' => $sopSteps,
            'totalSteps' => $totalSteps,
            'progressSaatIni' => $progressSaatIni,
            'progressPerWilayah' => $progressPerWilayah,
            'grafikTahunan' => $grafikTahunan,
            'progressScoped' => $progressScoped,
        ]);
    }
}
