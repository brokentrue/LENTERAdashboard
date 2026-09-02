<?php

namespace App\Models;

use CodeIgniter\Model;

class SopStepsModel extends Model
{
    protected $table = 'sop_steps';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'step_number',
        'title',
        'description',
        'is_active',
    ];

    protected $useTimestamps = true;
}