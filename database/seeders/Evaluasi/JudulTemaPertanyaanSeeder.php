<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\JudulTemaPertanyaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JudulTemaPertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarJudulTemaPertanyaan = [
            [
                'area_evaluasi_id' => 1,
                'judul' => 'Karakteristik Instansi/Perusahaan',
                'letakkan_sebelum_nomor' => 1
            ],
            [
                'area_evaluasi_id' => 2,
                'judul' => 'Fungsi/Organisasi Keamanan Informasi',
                'letakkan_sebelum_nomor' => 1
            ],
            [
                'area_evaluasi_id' => 3,
                'judul' => 'Kajian Risiko Keamanan Informasi',
                'letakkan_sebelum_nomor' => 1
            ],
            [
                'area_evaluasi_id' => 4,
                'judul' => 'Penyusunan dan Pengelolaan Kebijakan & Prosedur Keamanan Informasi',
                'letakkan_sebelum_nomor' => 1
            ],
            [
                'area_evaluasi_id' => 4,
                'judul' => 'Pengelolaan Strategi dan Program Keamanan Informasi',
                'letakkan_sebelum_nomor' => 23
            ],
            [
                'area_evaluasi_id' => 5,
                'judul' => 'Pengelolaan Aset Informasi',
                'letakkan_sebelum_nomor' => 1
            ],
            [
                'area_evaluasi_id' => 5,
                'judul' => 'Pengamanan Layanan Infrastruktur Awan (Cloud Service)',
                'letakkan_sebelum_nomor' => 31
            ],
            [
                'area_evaluasi_id' => 5,
                'judul' => 'Pengamanan Fisik',
                'letakkan_sebelum_nomor' => 42
            ],
            [
                'area_evaluasi_id' => 6,
                'judul' => 'Pengamanan Teknologi',
                'letakkan_sebelum_nomor' => 1
            ],
            [
                'area_evaluasi_id' => 7,
                'judul' => 'Pelindungan Data Pribadi',
                'letakkan_sebelum_nomor' => 1
            ],
        ];

        JudulTemaPertanyaan::insert($daftarJudulTemaPertanyaan);
    }
}
