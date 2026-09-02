<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProgressModel;

class Progress extends BaseController
{
    public function index()
    {
        return redirect()->to(site_url('dashboard'));
    }

   public function detail($id)
{
    $progressModel = new ProgressModel();
    $db = \Config\Database::connect();

    // $id adalah ID SOP dari tabel sop_steps

    $progress = $progressModel
        ->select('
            progress.*,
            sop_steps.id AS sop_id,
            sop_steps.step_number,
            sop_steps.title,
            sop_steps.description
        ')
        ->join(
            'sop_steps',
            'sop_steps.id = progress.sop_step_id'
        )
        ->where('progress.sop_step_id', $id)
        ->first();

    if (!$progress) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
            'Progress SOP tidak ditemukan.'
        );
    }

    // Ambil seluruh checkpoint SOP
    $tracingSteps = $db->table('sop_tracing_steps sts')
        ->select('
            sts.id AS tracing_step_id,
            sts.sop_step_id,
            sts.urutan,
            sts.nama_proses,
            sts.deskripsi,
            pt.id AS progress_tracing_id,
            pt.status,
            pt.catatan,
            pt.tanggal_update,
            pt.updated_by
        ')
        ->join(
            'progress_tracing pt',
            'pt.tracing_step_id = sts.id
             AND pt.progress_id = ' . (int) $progress['id'],
            'left'
        )
        ->where('sts.sop_step_id', $id)
        ->where('sts.is_active', 1)
        ->orderBy('sts.urutan', 'ASC')
        ->get()
        ->getResultArray();

    // Hitung progress checkpoint
    $totalTracing = count($tracingSteps);
    $completedTracing = 0;
    $processTracing = 0;

    foreach ($tracingSteps as $tracing) {

        if ($tracing['status'] === 'selesai') {
            $completedTracing++;
        }

        if ($tracing['status'] === 'proses') {
            $processTracing++;
        }
    }

    $progressPercent = $totalTracing > 0
        ? round(($completedTracing / $totalTracing) * 100, 1)
        : 0;

    return view('progress/detail', [
        'title'            => 'Detail Tracing SOP',
        'progress'         => $progress,
        'tracingSteps'     => $tracingSteps,
        'totalTracing'     => $totalTracing,
        'completedTracing' => $completedTracing,
        'processTracing'   => $processTracing,
        'progressPercent'  => $progressPercent,
    ]);
}
}