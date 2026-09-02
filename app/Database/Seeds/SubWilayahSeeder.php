<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubWilayahSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Sub Wilayah Barat I',
            ],
            [
                'name' => 'Sub Wilayah Barat II',
            ],
            [
                'name' => 'Sub Wilayah Timur I',
            ],
            [
                'name' => 'Sub Wilayah Timur II',
            ],
        ];

        $this->db->table('sub_wilayah')->insertBatch($data);
    }
}