<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\AreaEvaluasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaEvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarAreaEvaluasi = [
            [
                'nama_evaluasi' => 'I Kategori SE',
                'judul' => 'Bagian I: Kategori Sistem Elektronik',
                'deskripsi' => 'Bagian ini mengevaluasi tingkat atau kategori sistem elektronik yang digunakan',
            ],
            [
                'nama_evaluasi' => 'II Tata Kelola',
                'judul' => 'Bagian II: Tata Kelola Keamanan Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kesiapan bentuk tata kelola keamanan informasi instansi/perusahaan beserta fungsi, tugas dan tanggung jawab pengelola keamanan informasi.',
            ],
            [
                'nama_evaluasi' => 'III Risiko',
                'judul' => 'Bagian III: Pengelolaan Risiko Keamanan Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kesiapan penerapan pengelolaan risiko keamanan informasi sebagai dasar penerapan strategi keamanan informasi.',
            ],
            [
                'nama_evaluasi' => 'IV Kerangka Kerja',
                'judul' => 'Bagian IV: Kerangka Kerja Pengelolaan Keamanan Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan dan kesiapan kerangka kerja (kebijakan & prosedur) pengelolaan keamanan informasi dan strategi penerapannya.',
            ],
            [
                'nama_evaluasi' => 'V Pengelolaan Aset',
                'judul' => 'Bagian V: Pengelolaan Aset Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan pengamanan aset informasi, termasuk keseluruhan siklus penggunaan aset tersebut.',
            ],
            [
                'nama_evaluasi' => 'VI Teknologi',
                'judul' => 'Bagian VI: Teknologi dan Keamanan Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan, konsistensi dan efektifitas penggunaan teknologi dalam pengamanan aset informasi.',
            ],
            [
                'nama_evaluasi' => 'VII PDP',
                'judul' => 'Bagian VII: Pelindungan Data Pribadi',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan, konsistensi dan efektifitas penerapan kontrol keamanan terkait Pelindungan Data Pribadi (PDP).',
            ],
            [
                'nama_evaluasi' => 'VIII Suplemen',
                'judul' => 'Bagian VIII: Suplemen',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan, konsistensi dan efektivitas penerapan mekanisme keamanan terkait risiko keterlibatan pihak ketiga eksternal dalam operasional penyelenggaraan layanan instansi/perusahaan.',
            ],
        ];

        foreach ($daftarAreaEvaluasi as $areaEvaluasi) {
            AreaEvaluasi::create([
                'nama_evaluasi' => $areaEvaluasi['nama_evaluasi'],
                'judul' => $areaEvaluasi['judul'],
                'deskripsi' => $areaEvaluasi['deskripsi'],
            ]);
        }
    }
}
