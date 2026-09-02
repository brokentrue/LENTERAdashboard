<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasaSidangSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        foreach ([2026, 2027] as $tahun) {
            for ($nomor = 1; $nomor <= 5; $nomor++) {
                $data[] = [
                    'tahun' => $tahun,
                    'nomor' => $nomor,
                ];
            }
        }

        $this->db->table('masa_sidang')->insertBatch($data);
    }
}