
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

        $userId = (int) (
            $session->get('user_id')
            ?: $session->get('id')
        );

        if ($userId <= 0) {
            return redirect()->to(site_url('login'));
        }

        // Identitas dan hak akses dibaca ulang dari database.
        $user = $db->table('users')
            ->select(
                'users.id, users.name, users.is_active,
                 users.sub_wilayah_id,
                 roles.name AS role_name,
                 sub_wilayah.name AS wilayah_name'
            )
            ->join('roles', 'roles.id = users.role_id')
            ->join(
                'sub_wilayah',
                'sub_wilayah.id = users.sub_wilayah_id',
                'left'
            )
            ->where('users.id', $userId)
            ->get()
            ->getRowArray();

        if (!$user || (int) $user['is_active'] !== 1) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('Akun tidak aktif atau tidak ditemukan.');
        }

        $isAdmin = $user['role_name'] === 'Admin';
        $isKoordinator = $user['role_name'] === 'Koordinator';

        if (!$isAdmin && !$isKoordinator) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('Akun belum memiliki akses dashboard.');
        }

        if ($isKoordinator && empty($user['sub_wilayah_id'])) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('Sub Wilayah belum ditetapkan oleh Admin.');
        }

        // Periode yang disediakan dalam LENTERA.
        $tahunList = [2026, 2027, 2028, 2029];
        $nomorMasaSidang = [1, 2, 3, 4, 5];

        $tahun = (int) ($this->request->getGet('tahun') ?: 2026);
        $nomor = (int) ($this->request->getGet('masa_sidang') ?: 1);

        if (!in_array($tahun, $tahunList, true)
            || !in_array($nomor, $nomorMasaSidang, true)) {
            return service('response')
                ->setStatusCode(400)
                ->setBody('Periode tidak valid.');
        }

        $periode = $db->table('masa_sidang')
            ->where('tahun', $tahun)
            ->where('nomor', $nomor)
            ->get()
            ->getRowArray();

        $masaSidangId = $periode
            ? (int) $periode['id']
            : null;

        $subWilayahList = $db->table('sub_wilayah')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        // Koordinator tidak dapat mengganti wilayah melalui URL.
        $subWilayahId = $isKoordinator
            ? (int) $user['sub_wilayah_id']
            : (int) $this->request->getGet('sub_wilayah');

        if ($subWilayahId <= 0) {
            $subWilayahId = null;
        }

        if ($subWilayahId !== null) {
            $valid = in_array(
                $subWilayahId,
                array_map(
                    static fn ($row) => (int) $row['id'],
                    $subWilayahList
                ),
                true
            );

            if (!$valid) {
                return service('response')
                    ->setStatusCode(400)
                    ->setBody('Sub Wilayah tidak valid.');
            }
        }

        // Scope data aspirasi untuk satu periode.
        $scopeAspirasi = static function ($query) use (
            $masaSidangId,
            $subWilayahId
        ) {
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

        $totalAspirasi = $scopeAspirasi(
            $db->table('aspirasi')
        )->countAllResults();

        $totalProvinsi = $scopeAspirasi(
            $db->table('aspirasi')
        )
            ->select('provinsi')
            ->where('provinsi IS NOT NULL', null, false)
            ->where('provinsi !=', '')
            ->groupBy('provinsi')
            ->countAllResults();

        $totalIsu = $scopeAspirasi(
            $db->table('aspirasi')
        )
            ->select('isu')
            ->where('isu IS NOT NULL', null, false)
            ->where('isu !=', '')
            ->groupBy('isu')
            ->countAllResults();

        $topicRows = $scopeAspirasi(
            $db->table('aspirasi')
        )
            ->select('isu, COUNT(*) AS total')
            ->where('isu IS NOT NULL', null, false)
            ->where('isu !=', '')
            ->groupBy('isu')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $topics = [];

        foreach ($topicRows as $topic) {
            $topics[] = [
                'name' => $topic['isu'],
                'total' => (int) $topic['total'],
                'percent' => $totalAspirasi > 0
                    ? round(
                        (int) $topic['total'] / $totalAspirasi * 100,
                        1
                    )
                    : 0,
            ];
        }

        $sopSteps = $db->table('sop_steps')
            ->where('is_active', 1)
            ->orderBy('step_number', 'ASC')
            ->get()
            ->getResultArray();

        $totalSteps = count($sopSteps);

        // Periksa apakah progress dapat dihitung secara aman.
        $progressScoped =
            $db->tableExists('progress')
            && $db->fieldExists('sub_wilayah_id', 'progress')
            && $db->fieldExists('masa_sidang_id', 'progress')
            && $db->fieldExists('sop_step_id', 'progress')
            && $db->fieldExists('status', 'progress');

        $calculateProgress = function (
            int $wilayahId,
            int $periodId
        ) use ($db, $sopSteps, $totalSteps, $progressScoped) {

            if (!$progressScoped || $totalSteps === 0) {
                return null;
            }

            $rows = $db->table('progress')
                ->select('sop_step_id, status')
                ->where('sub_wilayah_id', $wilayahId)
                ->where('masa_sidang_id', $periodId)
                ->get()
                ->getResultArray();

            if (!$rows) {
                return null;
            }

            $statusByStep = [];

            foreach ($rows as $row) {
                $statusByStep[(int) $row['sop_step_id']] =
                    $row['status'];
            }

            $completed = 0;

            foreach ($sopSteps as $step) {
                if (
                    ($statusByStep[(int) $step['id']] ?? '')
                    === 'completed'
                ) {
                    $completed++;
                }
            }

            return [
                'completed' => $completed,
                'total' => $totalSteps,
                'percent' => round(
                    $completed / $totalSteps * 100,
                    1
                ),
                'statuses' => $statusByStep,
            ];
        };

        // Progress periode yang sedang dipilih.
        $progressPerWilayah = [];

        foreach ($subWilayahList as $wilayah) {
            $wilayahId = (int) $wilayah['id'];

            if (
                $subWilayahId !== null
                && $wilayahId !== $subWilayahId
            ) {
                continue;
            }

            $progressPerWilayah[$wilayahId] =
                $masaSidangId !== null
                    ? $calculateProgress(
                        $wilayahId,
                        $masaSidangId
                    )
                    : null;
        }

        $progressSaatIni = $subWilayahId !== null
            ? ($progressPerWilayah[$subWilayahId] ?? null)
            : null;

        foreach ($sopSteps as &$step) {
            $step['status'] = $progressSaatIni['statuses'][
                (int) $step['id']
            ] ?? 'pending';
        }
        unset($step);

        // Grafik tahunan: rata-rata dari Masa Sidang
        // yang sudah memiliki data progress.
        $grafikTahunan = [];

        foreach ($tahunList as $tahunGrafik) {
            $periodeRows = $db->table('masa_sidang')
                ->where('tahun', $tahunGrafik)
                ->get()
                ->getResultArray();

            $periodIds = [];

            foreach ($periodeRows as $p) {
                $periodIds[(int) $p['nomor']] = (int) $p['id'];
            }

            $series = [];

            foreach ($subWilayahList as $wilayah) {
                $wilayahId = (int) $wilayah['id'];

                if (
                    $subWilayahId !== null
                    && $wilayahId !== $subWilayahId
                ) {
                    continue;
                }

                $nilai = [];

                for ($ms = 1; $ms <= 5; $ms++) {
                    if (!isset($periodIds[$ms])) {
                        continue;
                    }

                    $hasil = $calculateProgress(
                        $wilayahId,
                        $periodIds[$ms]
                    );

                    if ($hasil !== null) {
                        $nilai[] = $hasil['percent'];
                    }
                }

                $series[$wilayahId] = $nilai
                    ? round(array_sum($nilai) / count($nilai), 1)
                    : null;
            }

            $grafikTahunan[] = [
                'tahun' => $tahunGrafik,
                'series' => $series,
            ];
        }

        return view(
            $isAdmin
                ? 'dashboard/index'
                : 'dashboard/koordinator',
            [
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
            ]
        );
    }
}
