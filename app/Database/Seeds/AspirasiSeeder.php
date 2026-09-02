<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AspirasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 1,
                'provinsi'       => 'Jawa Barat',
                'sumber'         => 'Anggota DPD RI',
                'isu'            => 'Infrastruktur',
                'uraian'         => 'Peningkatan kualitas jalan dan konektivitas antarwilayah.',
                'status'         => 'Baru',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 1,
                'provinsi'       => 'Banten',
                'sumber'         => 'Masyarakat',
                'isu'            => 'Pendidikan',
                'uraian'         => 'Peningkatan sarana dan prasarana pendidikan daerah.',
                'status'         => 'Diproses',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 1,
                'provinsi'       => 'DKI Jakarta',
                'sumber'         => 'Reses',
                'isu'            => 'Kesehatan',
                'uraian'         => 'Peningkatan akses layanan kesehatan masyarakat.',
                'status'         => 'Selesai',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 2,
                'provinsi'       => 'Jawa Tengah',
                'sumber'         => 'Masyarakat',
                'isu'            => 'Ekonomi',
                'uraian'         => 'Penguatan UMKM dan akses pembiayaan masyarakat.',
                'status'         => 'Baru',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 2,
                'provinsi'       => 'Jawa Timur',
                'sumber'         => 'Anggota DPD RI',
                'isu'            => 'Infrastruktur',
                'uraian'         => 'Pembangunan dan pemeliharaan infrastruktur daerah.',
                'status'         => 'Diproses',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 3,
                'provinsi'       => 'Sulawesi Selatan',
                'sumber'         => 'Reses',
                'isu'            => 'Ekonomi',
                'uraian'         => 'Pengembangan potensi ekonomi dan perdagangan daerah.',
                'status'         => 'Baru',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 3,
                'provinsi'       => 'Nusa Tenggara Timur',
                'sumber'         => 'Masyarakat',
                'isu'            => 'Infrastruktur',
                'uraian'         => 'Peningkatan akses transportasi dan konektivitas wilayah.',
                'status'         => 'Diproses',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 4,
                'provinsi'       => 'Papua',
                'sumber'         => 'Anggota DPD RI',
                'isu'            => 'Pendidikan',
                'uraian'         => 'Pemerataan akses pendidikan di wilayah terpencil.',
                'status'         => 'Baru',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 4,
                'provinsi'       => 'Maluku',
                'sumber'         => 'Masyarakat',
                'isu'            => 'Kesehatan',
                'uraian'         => 'Penguatan fasilitas dan tenaga kesehatan daerah kepulauan.',
                'status'         => 'Diproses',
            ],
            [
                'masa_sidang_id' => 1,
                'sub_wilayah_id' => 4,
                'provinsi'       => 'Maluku Utara',
                'sumber'         => 'Reses',
                'isu'            => 'Ekonomi',
                'uraian'         => 'Pengembangan ekonomi masyarakat berbasis potensi daerah.',
                'status'         => 'Baru',
            ],
        ];

        $this->db->table('aspirasi')->insertBatch($data);
    }
}