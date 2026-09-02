<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SopStepsModel;
use App\Models\ProgressModel;

class Progress extends BaseController
{
    public function index()
    {
        $sopModel = new SopStepsModel();
        $progressModel = new ProgressModel();

        $steps = $sopModel
            ->where('is_active', 1)
            ->orderBy('step_number', 'ASC')
            ->findAll();

        foreach ($steps as &$step) {

            $progress = $progressModel
                ->where('sop_step_id', $step['id'])
                ->first();

            $step['status'] = $progress['status'] ?? 'pending';
        }

        unset($step);

        $completedSteps = 0;

        foreach ($steps as $step) {
            if ($step['status'] === 'completed') {
                $completedSteps++;
            }
        }

        $totalSteps = count($steps);

        $progressPercent = $totalSteps > 0
            ? round(($completedSteps / $totalSteps) * 100, 1)
            : 0;

        return view('progress/index', [
            'title' => 'Detail Progress SOP',
            'steps' => $steps,
            'totalSteps' => $totalSteps,
            'completedSteps' => $completedSteps,
            'progressPercent' => $progressPercent,
        ]);
    }
}