<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressTracingModel extends Model
{
    protected $table = 'progress_tracing';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'progress_id',
        'tracing_step_id',
        'status',
        'catatan',
        'tanggal_update',
        'updated_by',
    ];

    protected $useTimestamps = true;

    protected $returnType = 'array';
}