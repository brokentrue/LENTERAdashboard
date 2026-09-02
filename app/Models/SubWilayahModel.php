<?php

namespace App\Models;

use CodeIgniter\Model;

class SubWilayahModel extends Model
{
    protected $table = 'sub_wilayah';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'name',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}