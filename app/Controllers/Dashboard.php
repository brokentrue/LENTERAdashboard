<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AspirasiModel;
use App\Models\ProgressModel;
use App\Models\SopStepsModel;
use App\Models\MasaSidangModel;
use App\Models\SubWilayahModel;

class Dashboard extends BaseController
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | MODEL
        |--------------------------------------------------------------------------
        */

        $aspirasiModel    = new AspirasiModel();
        $progressModel    = new ProgressModel();
        $sopModel         = new SopStepsModel();
        $masaSidangModel  = new MasaSidangModel();
        $subWilayahModel  = new SubWilayahModel();


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $tahun          = $this->request->getGet('tahun');
        $masaSidangId   = $this->request->getGet('masa_sidang');
        $subWilayahId   = $this->request->getGet('sub_wilayah');


        /*
        |--------------------------------------------------------------------------
        | DAFTAR FILTER
        |--------------------------------------------------------------------------
        */

        $tahunList = $masaSidangModel
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'DESC')
            ->findAll();

        $masaSidangList = $masaSidangModel
            ->orderBy('tahun', 'DESC')
            ->orderBy('nomor', 'ASC')
            ->findAll();

        $subWilayahList = $subWilayahModel
            ->orderBy('id', 'ASC')
            ->findAll();


        /*
        |--------------------------------------------------------------------------
        | PERIODE DEFAULT
        |--------------------------------------------------------------------------
        */

        $activePeriod = $masaSidangModel
            ->orderBy('tahun', 'DESC')
            ->orderBy('nomor', 'DESC')
            ->first();

        if (!$activePeriod) {
            $activePeriod = [
                'id'    => null,
                'tahun' => date('Y'),
                'nomor' => 1
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER ASPIRASI
        |--------------------------------------------------------------------------
        */

        $aspirasiQuery = $aspirasiModel;


        /*
        | Filter Tahun
        */

        if (!empty($tahun)) {

            $masaIds = $masaSidangModel
                ->select('id')
                ->where('tahun', $tahun)
                ->findColumn('id');

            if (!empty($masaIds)) {
                $aspirasiQuery->whereIn('masa_sidang_id', $masaIds);
            } else {
                $aspirasiQuery->where('id', 0);
            }
        }


        /*
        | Filter Masa Sidang
        */

        if (!empty($masaSidangId)) {
            $aspirasiQuery->where('masa_sidang_id', $masaSidangId);
        }


        /*
        | Filter Sub Wilayah
        */

        if (!empty($subWilayahId)) {
            $aspirasiQuery->where('sub_wilayah_id', $subWilayahId);
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL ASPIRASI
        |--------------------------------------------------------------------------
        */

        $totalAspirasi = $aspirasiQuery->countAllResults();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PROVINSI
        |--------------------------------------------------------------------------
        */

        $provinsiQuery = $aspirasiModel
            ->select('provinsi')
            ->where('provinsi IS NOT NULL')
            ->where('provinsi !=', '');

        if (!empty($tahun)) {

            $masaIds = $masaSidangModel
                ->select('id')
                ->where('tahun', $tahun)
                ->findColumn('id');

            if (!empty($masaIds)) {
                $provinsiQuery->whereIn('masa_sidang_id', $masaIds);
            } else {
                $provinsiQuery->where('id', 0);
            }
        }

        if (!empty($masaSidangId)) {
            $provinsiQuery->where('masa_sidang_id', $masaSidangId);
        }

        if (!empty($subWilayahId)) {
            $provinsiQuery->where('sub_wilayah_id', $subWilayahId);
        }

        $totalProvinsi = $provinsiQuery
            ->groupBy('provinsi')
            ->countAllResults();


        /*
        |--------------------------------------------------------------------------
        | TOTAL ISU
        |--------------------------------------------------------------------------
        */

        $isuQuery = $aspirasiModel
            ->select('isu')
            ->where('isu IS NOT NULL')
            ->where('isu !=', '');

        if (!empty($tahun)) {

            $masaIds = $masaSidangModel
                ->select('id')
                ->where('tahun', $tahun)
                ->findColumn('id');

            if (!empty($masaIds)) {
                $isuQuery->whereIn('masa_sidang_id', $masaIds);
            } else {
                $isuQuery->where('id', 0);
            }
        }

        if (!empty($masaSidangId)) {
            $isuQuery->where('masa_sidang_id', $masaSidangId);
        }

        if (!empty($subWilayahId)) {
            $isuQuery->where('sub_wilayah_id', $subWilayahId);
        }

        $totalIsu = $isuQuery
            ->groupBy('isu')
            ->countAllResults();


        /*
        |--------------------------------------------------------------------------
        | DATA SOP
        |--------------------------------------------------------------------------
        */

        $sopSteps = $sopModel
            ->where('is_active', 1)
            ->orderBy('step_number', 'ASC')
            ->findAll();

        $totalSteps = count($sopSteps);

        $completedSteps = 0;

        if ($totalSteps > 0) {

            foreach ($sopSteps as &$step) {

                $progress = $progressModel
                    ->where('sop_step_id', $step['id'])
                    ->first();

                $step['status'] = 'pending';

                if ($progress) {

                    $step['status'] = $progress['status'] ?? 'pending';

                    if (($progress['status'] ?? '') === 'completed') {
                        $completedSteps++;
                    }
                }
            }

            unset($step);
        }


        /*
        |--------------------------------------------------------------------------
        | PROGRESS PERCENT
        |--------------------------------------------------------------------------
        */

        $progressPercent = $totalSteps > 0
            ? round(($completedSteps / $totalSteps) * 100, 1)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | TOPIK ASPIRASI
        |--------------------------------------------------------------------------
        */

        $topicQuery = $aspirasiModel
            ->select('isu, COUNT(*) as total')
            ->where('isu IS NOT NULL')
            ->where('isu !=', '');

        if (!empty($tahun)) {

            $masaIds = $masaSidangModel
                ->select('id')
                ->where('tahun', $tahun)
                ->findColumn('id');

            if (!empty($masaIds)) {
                $topicQuery->whereIn('masa_sidang_id', $masaIds);
            } else {
                $topicQuery->where('id', 0);
            }
        }

        if (!empty($masaSidangId)) {
            $topicQuery->where('masa_sidang_id', $masaSidangId);
        }

        if (!empty($subWilayahId)) {
            $topicQuery->where('sub_wilayah_id', $subWilayahId);
        }

        $topicRows = $topicQuery
            ->groupBy('isu')
            ->orderBy('total', 'DESC')
            ->findAll(5);


        $topics = [];

        if ($totalAspirasi > 0) {

            foreach ($topicRows as $topic) {

                $topics[] = [
                    'name' => $topic['isu'],
                    'total' => (int) $topic['total'],
                    'percent' => round(
                        ((int) $topic['total'] / $totalAspirasi) * 100,
                        1
                    )
                ];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        $data = [

            'title' => 'Dashboard LENTERA',

            'totalAspirasi' => $totalAspirasi,
            'totalIsu' => $totalIsu,
            'totalProvinsi' => $totalProvinsi,

            'sopSteps' => $sopSteps,
            'totalSteps' => $totalSteps,
            'completedSteps' => $completedSteps,
            'progressPercent' => $progressPercent,

            'topics' => $topics,

            'activePeriod' => $activePeriod,

            'tahun' => $tahun,
            'masaSidangId' => $masaSidangId,
            'subWilayahId' => $subWilayahId,

            'tahunList' => $tahunList,
            'masaSidangList' => $masaSidangList,
            'subWilayahList' => $subWilayahList,
        ];


        /*
        |--------------------------------------------------------------------------
        | RENDER
        |--------------------------------------------------------------------------
        */

        return view('dashboard/index', $data);
    }
}