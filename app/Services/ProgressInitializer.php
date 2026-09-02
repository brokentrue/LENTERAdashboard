<?php

namespace App\Services;

use App\Models\ProgressModel;
use App\Models\ProgressTracingModel;

class ProgressInitializer
{
    protected ProgressModel $progressModel;
    protected ProgressTracingModel $progressTracingModel;

    public function __construct()
    {
        $this->progressModel = new ProgressModel();
        $this->progressTracingModel = new ProgressTracingModel();
    }

    public function initialize(int $subWilayahId, int $masaSidangId): array
    {
        $db = \Config\Database::connect();

        $sopSteps = $db->table('sop_steps')
            ->where('is_active', 1)
            ->orderBy('step_number', 'ASC')
            ->get()
            ->getResultArray();

        $createdProgress = 0;
        $createdTracing = 0;

        foreach ($sopSteps as $sop) {

            $progress = $this->progressModel
                ->where('sub_wilayah_id', $subWilayahId)
                ->where('masa_sidang_id', $masaSidangId)
                ->where('sop_step_id', $sop['id'])
                ->first();

            if (!$progress) {

                $progressId = $this->progressModel->insert([
                    'sub_wilayah_id' => $subWilayahId,
                    'masa_sidang_id' => $masaSidangId,
                    'sop_step_id'    => $sop['id'],
                    'status'         => 'belum',
                    'catatan'        => null,
                    'tanggal_update' => null,
                    'updated_by'     => null,
                ], true);

                $createdProgress++;

            } else {
                $progressId = $progress['id'];
            }

            $tracingSteps = $db->table('sop_tracing_steps')
                ->where('sop_step_id', $sop['id'])
                ->where('is_active', 1)
                ->orderBy('urutan', 'ASC')
                ->get()
                ->getResultArray();

            foreach ($tracingSteps as $tracingStep) {

                $existingTracing = $this->progressTracingModel
                    ->where('progress_id', $progressId)
                    ->where('tracing_step_id', $tracingStep['id'])
                    ->first();

                if (!$existingTracing) {

                    $this->progressTracingModel->insert([
                        'progress_id'     => $progressId,
                        'tracing_step_id' => $tracingStep['id'],
                        'status'          => null,
                        'catatan'         => null,
                        'tanggal_update'  => null,
                        'updated_by'      => null,
                    ]);

                    $createdTracing++;
                }
            }
        }

        return [
            'created_progress' => $createdProgress,
            'created_tracing'  => $createdTracing,
        ];
    }
}