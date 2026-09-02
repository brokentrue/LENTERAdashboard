<?php

namespace App\Models;

use CodeIgniter\Model;

class MasaSidangModel extends Model
{
    protected $table = 'masa_sidang';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'tahun',
        'nomor',
    ];

    protected $useTimestamps = true;
}