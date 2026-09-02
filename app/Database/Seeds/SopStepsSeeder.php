<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SopStepsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'step_number' => 1,
                'title' => 'Input Hasil Aspirasi',
                'description' => 'Menginput hasil penyerapan aspirasi masyarakat dan daerah (reses) melalui aplikasi ASMASDA dan mengirimkan pokok-pokok hasil penyerapan aspirasi kepada Sekretariat Pimpinan yang bertugas sebagai Sekretariat Sub Wilayah.',
            ],
            [
                'step_number' => 2,
                'title' => 'Penerimaan Pokok Aspirasi',
                'description' => 'Menerima pokok-pokok hasil penyerapan aspirasi Anggota Sub Wilayah dan menugaskan Kasubbag Penyiapan Materi untuk melakukan inventarisasi serta menyiapkan bahan Rapat Sub Wilayah.',
            ],
            [
                'step_number' => 3,
                'title' => 'Inventarisasi Aspirasi',
                'description' => 'Menugaskan Penelaah Teknis Kebijakan untuk menginventarisasi, mengelompokkan, dan menyiapkan bahan pembahasan hasil penyerapan aspirasi masyarakat dan daerah.',
            ],
            [
                'step_number' => 4,
                'title' => 'Pengelompokan Isu',
                'description' => 'Menginventarisasi dan mengelompokkan pokok-pokok aspirasi berdasarkan isu dan wilayah/provinsi, menyusun matriks bahan Rapat Sub Wilayah, kemudian menyampaikan kepada Kasubbag untuk diperiksa.',
            ],
            [
                'step_number' => 5,
                'title' => 'Pemeriksaan Matriks',
                'description' => 'Memeriksa dan menyetujui draft matriks inventarisasi dan bahan Rapat Sub Wilayah, kemudian menyampaikan kepada Kabag untuk memperoleh persetujuan.',
            ],
            [
                'step_number' => 6,
                'title' => 'Persetujuan Bahan Rapat',
                'description' => 'Menerima dan menyetujui bahan Rapat Sub Wilayah serta mengoordinasikan penyiapan pelaksanaan Rapat Sub Wilayah.',
            ],
            [
                'step_number' => 7,
                'title' => 'Pelaksanaan Rapat Sub Wilayah',
                'description' => 'Melaksanakan Rapat Sub Wilayah untuk membahas hasil penyerapan aspirasi, menetapkan isu krusial yang akan dilaporkan dalam Sidang Paripurna, mengidentifikasi isu kewilayahan/regional dan isu nasional, serta menetapkan 2 (dua) provinsi sebagai perwakilan penyampai laporan.',
            ],
            [
                'step_number' => 8,
                'title' => 'Penyusunan Hasil Rapat',
                'description' => 'Menyusun notulen, matriks hasil pembahasan, dan draft laporan hasil penyerapan aspirasi Sub Wilayah berdasarkan keputusan Rapat Sub Wilayah, kemudian menyampaikan kepada Kasubbag.',
            ],
            [
                'step_number' => 9,
                'title' => 'Pemeriksaan Laporan',
                'description' => 'Memeriksa dan menyetujui hasil Rapat Sub Wilayah dan draft laporan, kemudian menyampaikan kepada Kabag untuk memperoleh persetujuan.',
            ],
            [
                'step_number' => 10,
                'title' => 'Persetujuan Laporan',
                'description' => 'Menyetujui laporan hasil Rapat Sub Wilayah dan mengoordinasikan penyampaian bahan kepada perwakilan Anggota Sub Wilayah serta bahan pendukung kepada unit terkait untuk proses Sidang Paripurna.',
            ],
            [
                'step_number' => 11,
                'title' => 'Penyampaian Laporan',
                'description' => 'Menyampaikan laporan hasil penyerapan aspirasi masyarakat dan daerah oleh perwakilan Anggota Sub Wilayah dalam Sidang Paripurna Pembukaan Masa Sidang.',
            ],
            [
                'step_number' => 12,
                'title' => 'Inventarisasi Tindak Lanjut',
                'description' => 'Menginventarisasi hasil identifikasi Rapat Sub Wilayah yang memerlukan tindak lanjut, memisahkan isu kewilayahan/regional dan isu nasional, serta menyusun matriks tindak lanjut dan alat kelengkapan DPD terkait, termasuk Pimpinan DPD RI.',
            ],
            [
                'step_number' => 13,
                'title' => 'Pemeriksaan Matriks Tindak Lanjut',
                'description' => 'Memeriksa matriks tindak lanjut dan menyiapkan bahan koordinasi tindak lanjut Sub Wilayah dengan alat kelengkapan DPD terkait, termasuk Pimpinan DPD RI.',
            ],
            [
                'step_number' => 14,
                'title' => 'Koordinasi Tindak Lanjut',
                'description' => 'Mengoordinasikan tindak lanjut isu kewilayahan/regional dengan alat kelengkapan DPD terkait, termasuk Pimpinan DPD RI, serta menyampaikan isu nasional kepada alat kelengkapan DPD sesuai dengan lingkup tugasnya untuk ditindaklanjuti dengan mitra kerja terkait.',
            ],
            [
                'step_number' => 15,
                'title' => 'Monitoring & Pengarsipan',
                'description' => 'Memantau status tindak lanjut, memperbarui matriks monitoring, menghimpun bukti tindak lanjut, dan mengarsipkan seluruh dokumen proses pelaporan dan tindak lanjut ASMASDA.',
            ],
        ];

        $this->db->table('sop_steps')->insertBatch($data);
    }
}