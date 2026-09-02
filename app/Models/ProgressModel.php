<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressModel extends Model
{
    protected $table = 'progress';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sub_wilayah_id',
        'masa_sidang_id',
        'sop_step_id',
        'status',
        'catatan',
        'tanggal_update',
        'updated_by',
    ];

    protected $useTimestamps = true;

    protected $returnType = 'array';
}