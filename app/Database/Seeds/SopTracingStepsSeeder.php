<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SopTracingStepsSeeder extends Seeder
{
    public function run()
    {
        $data = [

            // SOP 01 — Input Hasil Aspirasi
            [
                'sop_step_id' => 1,
                'urutan' => 1,
                'nama_proses' => 'Data aspirasi diinput ke ASMASDA.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 1,
                'urutan' => 2,
                'nama_proses' => 'Pokok aspirasi dikirim ke email terpusat Staf Ahli masing-masing Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 02 — Penerimaan Pokok Aspirasi
            [
                'sop_step_id' => 2,
                'urutan' => 1,
                'nama_proses' => 'Pokok aspirasi diterima melalui email terpusat dan berhasil di-inject ke dalam sistem ASMASDA.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 2,
                'urutan' => 2,
                'nama_proses' => 'Data diperiksa dan dicatat oleh Staf Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 2,
                'urutan' => 3,
                'nama_proses' => 'Aspirasi dikelompokkan untuk proses inventarisasi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 2,
                'urutan' => 4,
                'nama_proses' => 'Penugasan kepada Kepala Subbagian Penyiapan Materi dilakukan oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 2,
                'urutan' => 5,
                'nama_proses' => 'Penugasan kepada Penelaah Teknis Kebijakan dilakukan untuk menyiapkan bahan Rapat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 03 — Inventarisasi Aspirasi
            [
                'sop_step_id' => 3,
                'urutan' => 1,
                'nama_proses' => 'Aspirasi diterima oleh Penelaah Teknis Kebijakan untuk diinventarisasi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 3,
                'urutan' => 2,
                'nama_proses' => 'Aspirasi diverifikasi dan dilengkapi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 3,
                'urutan' => 3,
                'nama_proses' => 'Aspirasi dikelompokkan berdasarkan substansi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 3,
                'urutan' => 4,
                'nama_proses' => 'Bahan inventarisasi disusun.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 3,
                'urutan' => 5,
                'nama_proses' => 'Hasil inventarisasi disiapkan untuk digunakan dalam pembahasan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 04 — Pengelompokan Isu
            [
                'sop_step_id' => 4,
                'urutan' => 1,
                'nama_proses' => 'Pokok aspirasi dikelompokkan berdasarkan isu.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 4,
                'urutan' => 2,
                'nama_proses' => 'Aspirasi dikelompokkan berdasarkan wilayah/provinsi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 4,
                'urutan' => 3,
                'nama_proses' => 'Matriks bahan Rapat Sub Wilayah disusun.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 4,
                'urutan' => 4,
                'nama_proses' => 'Matriks diperiksa oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 4,
                'urutan' => 5,
                'nama_proses' => 'Matriks disiapkan untuk disampaikan kepada Kepala Bagian Sekretariat Sub Wilayah untuk pemeriksaan dan persetujuan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 05 — Pemeriksaan Matriks
            [
                'sop_step_id' => 5,
                'urutan' => 1,
                'nama_proses' => 'Draft matriks diterima oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 5,
                'urutan' => 2,
                'nama_proses' => 'Draft matriks diperiksa untuk memperoleh persetujuan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 5,
                'urutan' => 3,
                'nama_proses' => 'Kelengkapan dan kesesuaian matriks diperiksa oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 5,
                'urutan' => 4,
                'nama_proses' => 'Substansi bahan Rapat Sub Wilayah diperiksa oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 5,
                'urutan' => 5,
                'nama_proses' => 'Matriks disetujui oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 5,
                'urutan' => 6,
                'nama_proses' => 'Matriks disampaikan kepada Kepala Bagian Sekretariat Sub Wilayah untuk memperoleh persetujuan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 06 — Persetujuan Bahan Rapat
            [
                'sop_step_id' => 6,
                'urutan' => 1,
                'nama_proses' => 'Bahan Rapat Sub Wilayah diterima oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 6,
                'urutan' => 2,
                'nama_proses' => 'Bahan Rapat Sub Wilayah diperiksa oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 6,
                'urutan' => 3,
                'nama_proses' => 'Perbaikan atau penyempurnaan dilakukan oleh Kepala Bagian Sekretariat Sub Wilayah apabila diperlukan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 6,
                'urutan' => 4,
                'nama_proses' => 'Bahan Rapat Sub Wilayah disetujui oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 6,
                'urutan' => 5,
                'nama_proses' => 'Persiapan pelaksanaan Rapat Sub Wilayah dikoordinasikan oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 07 — Pelaksanaan Rapat Sub Wilayah
            [
                'sop_step_id' => 7,
                'urutan' => 1,
                'nama_proses' => 'Rapat Sub Wilayah dijadwalkan sesuai jadwal Masa Sidang Panmus.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 7,
                'urutan' => 2,
                'nama_proses' => 'Persiapan Rapat dilakukan oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 7,
                'urutan' => 3,
                'nama_proses' => 'Rapat Sub Wilayah dilaksanakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 7,
                'urutan' => 4,
                'nama_proses' => 'Isu krusial serta isu kewilayahan/regional dan isu nasional ditetapkan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 7,
                'urutan' => 5,
                'nama_proses' => 'Perwakilan provinsi penyampai laporan ditetapkan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 08 — Penyusunan Hasil Rapat
            [
                'sop_step_id' => 8,
                'urutan' => 1,
                'nama_proses' => 'Hasil keputusan Rapat dihimpun oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 8,
                'urutan' => 2,
                'nama_proses' => 'Notulen Rapat disusun oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 8,
                'urutan' => 3,
                'nama_proses' => 'Matriks hasil pembahasan disusun oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 8,
                'urutan' => 4,
                'nama_proses' => 'Draft laporan hasil aspirasi disusun oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 8,
                'urutan' => 5,
                'nama_proses' => 'Dokumen disampaikan kepada Kepala Subbagian Penyiapan Materi oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 09 — Pemeriksaan Laporan
            [
                'sop_step_id' => 9,
                'urutan' => 1,
                'nama_proses' => 'Draft laporan diterima oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 9,
                'urutan' => 2,
                'nama_proses' => 'Kesesuaian laporan dengan hasil Rapat diperiksa oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 9,
                'urutan' => 3,
                'nama_proses' => 'Kelengkapan laporan diperiksa oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 9,
                'urutan' => 4,
                'nama_proses' => 'Perbaikan laporan dilakukan oleh Kepala Subbagian Penyiapan Materi apabila diperlukan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 9,
                'urutan' => 5,
                'nama_proses' => 'Laporan disampaikan kepada Kepala Bagian Sekretariat Sub Wilayah oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 10 — Persetujuan Laporan
            [
                'sop_step_id' => 10,
                'urutan' => 1,
                'nama_proses' => 'Laporan diterima oleh Kepala Bagian Sekretariat Sub Wilayah untuk memperoleh persetujuan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 10,
                'urutan' => 2,
                'nama_proses' => 'Laporan diperiksa kembali oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 10,
                'urutan' => 3,
                'nama_proses' => 'Laporan disetujui oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 10,
                'urutan' => 4,
                'nama_proses' => 'Bahan yang telah disetujui disampaikan kepada Anggota DPD RI yang telah ditetapkan untuk membacakan laporan dalam Sidang Paripurna.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 11 — Penyampaian Laporan
            [
                'sop_step_id' => 11,
                'urutan' => 1,
                'nama_proses' => 'Laporan final diterima oleh Anggota DPD RI yang ditugaskan untuk membacakan laporan dalam Sidang Paripurna.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 11,
                'urutan' => 2,
                'nama_proses' => 'Bahan penyampaian laporan disiapkan oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 11,
                'urutan' => 3,
                'nama_proses' => 'Anggota DPD RI yang ditugaskan menyampaikan laporan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 11,
                'urutan' => 4,
                'nama_proses' => 'Laporan disampaikan dalam Sidang Paripurna.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 11,
                'urutan' => 5,
                'nama_proses' => 'Bukti atau dokumentasi penyampaian laporan dihimpun oleh Staf Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 12 — Inventarisasi Tindak Lanjut
            [
                'sop_step_id' => 12,
                'urutan' => 1,
                'nama_proses' => 'Hasil identifikasi Rapat dihimpun oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 12,
                'urutan' => 2,
                'nama_proses' => 'Isu yang memerlukan tindak lanjut diidentifikasi oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 12,
                'urutan' => 3,
                'nama_proses' => 'Isu kewilayahan/regional dan isu nasional dipisahkan oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 12,
                'urutan' => 4,
                'nama_proses' => 'Matriks tindak lanjut disusun oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 12,
                'urutan' => 5,
                'nama_proses' => 'Alat kelengkapan atau pihak terkait ditentukan oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 13 — Pemeriksaan Matriks Tindak Lanjut
            [
                'sop_step_id' => 13,
                'urutan' => 1,
                'nama_proses' => 'Matriks tindak lanjut diterima oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 13,
                'urutan' => 2,
                'nama_proses' => 'Kelengkapan matriks diperiksa oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 13,
                'urutan' => 3,
                'nama_proses' => 'Tujuan dan pihak tindak lanjut diverifikasi oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 13,
                'urutan' => 4,
                'nama_proses' => 'Matriks disempurnakan oleh Kepala Subbagian Penyiapan Materi apabila diperlukan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 13,
                'urutan' => 5,
                'nama_proses' => 'Bahan koordinasi tindak lanjut disiapkan oleh Kepala Subbagian Penyiapan Materi.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 14 — Koordinasi Tindak Lanjut
            [
                'sop_step_id' => 14,
                'urutan' => 1,
                'nama_proses' => 'Isu prioritas tindak lanjut ditetapkan oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 14,
                'urutan' => 2,
                'nama_proses' => 'Bahan koordinasi tindak lanjut disiapkan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 14,
                'urutan' => 3,
                'nama_proses' => 'Koordinasi dengan alat kelengkapan DPD dilakukan oleh Kepala Bagian Sekretariat Sub Wilayah.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 14,
                'urutan' => 4,
                'nama_proses' => 'Isu nasional diteruskan kepada alat kelengkapan DPD terkait.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 14,
                'urutan' => 5,
                'nama_proses' => 'Hasil koordinasi dicatat dalam matriks monitoring.',
                'deskripsi' => null,
                'is_active' => 1,
            ],

            // SOP 15 — Monitoring & Pengarsipan
            [
                'sop_step_id' => 15,
                'urutan' => 1,
                'nama_proses' => 'Status tindak lanjut dipantau oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 15,
                'urutan' => 2,
                'nama_proses' => 'Matriks monitoring diperbarui oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 15,
                'urutan' => 3,
                'nama_proses' => 'Bukti tindak lanjut dihimpun oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 15,
                'urutan' => 4,
                'nama_proses' => 'Status penyelesaian diperbarui oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
            [
                'sop_step_id' => 15,
                'urutan' => 5,
                'nama_proses' => 'Seluruh dokumen diarsipkan oleh Penelaah Teknis Kebijakan.',
                'deskripsi' => null,
                'is_active' => 1,
            ],
        ];

        $this->db->table('sop_tracing_steps')->insertBatch($data);
    }
}