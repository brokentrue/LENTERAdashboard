<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Sub Wilayah Barat I DPD RI',
            ],
            [
                'name' => 'Sub Wilayah Barat II DPD RI',
            ],
            [
                'name' => 'Sub Wilayah Timur I DPD RI',
            ],
            [
                'name' => 'Sub Wilayah Timur II DPD RI',
            ],
            [
                'name' => 'Koordinator',
            ],
            [
                'name' => 'Admin',
            ],
        ];

        $this->db->table('roles')->insertBatch($roles);
    }
}