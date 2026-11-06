<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SeedMasaSidang2026To2029 extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        for ($tahun = 2026; $tahun <= 2029; $tahun++) {
            for ($nomor = 1; $nomor <= 5; $nomor++) {

                $exists = $db->table('masa_sidang')
                    ->where('tahun', $tahun)
                    ->where('nomor', $nomor)
                    ->countAllResults();

                if ($exists > 0) {
                    continue;
                }

                $db->table('masa_sidang')->insert([
                    'tahun' => $tahun,
                    'nomor' => $nomor,
                ]);
            }
        }
    }

    public function down()
    {
        // Tidak menghapus periode agar data operasional
        // yang sudah terhubung tetap aman.
    }
}
