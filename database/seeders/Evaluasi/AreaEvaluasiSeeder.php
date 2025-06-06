<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\EvaluasiUtama;
use App\Models\Responden\NilaiEvaluasiUtama;
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
                'tipe_evaluasi_id' => 1,
                'nama_evaluasi' => 'I Kategori SE',
                'judul' => 'Bagian I: Kategori Sistem Elektronik',
                'deskripsi' => 'Bagian ini mengevaluasi tingkat atau kategori sistem elektronik yang digunakan',
            ],
            [
                'tipe_evaluasi_id' => 2,
                'nama_evaluasi' => 'II Tata Kelola',
                'judul' => 'Bagian II: Tata Kelola Keamanan Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kesiapan bentuk tata kelola keamanan informasi instansi/perusahaan beserta fungsi, tugas dan tanggung jawab pengelola keamanan informasi.',
            ],
            [
                'tipe_evaluasi_id' => 2,
                'nama_evaluasi' => 'III Risiko',
                'judul' => 'Bagian III: Pengelolaan Risiko Keamanan Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kesiapan penerapan pengelolaan risiko keamanan informasi sebagai dasar penerapan strategi keamanan informasi.',
            ],
            [
                'tipe_evaluasi_id' => 2,
                'nama_evaluasi' => 'IV Kerangka Kerja',
                'judul' => 'Bagian IV: Kerangka Kerja Pengelolaan Keamanan Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan dan kesiapan kerangka kerja (kebijakan & prosedur) pengelolaan keamanan informasi dan strategi penerapannya.',
            ],
            [
                'tipe_evaluasi_id' => 2,
                'nama_evaluasi' => 'V Pengelolaan Aset',
                'judul' => 'Bagian V: Pengelolaan Aset Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan pengamanan aset informasi, termasuk keseluruhan siklus penggunaan aset tersebut.',
            ],
            [
                'tipe_evaluasi_id' => 2,
                'nama_evaluasi' => 'VI Teknologi',
                'judul' => 'Bagian VI: Teknologi dan Keamanan Informasi',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan, konsistensi dan efektifitas penggunaan teknologi dalam pengamanan aset informasi.',
            ],
            [
                'tipe_evaluasi_id' => 2,
                'nama_evaluasi' => 'VII PDP',
                'judul' => 'Bagian VII: Pelindungan Data Pribadi',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan, konsistensi dan efektifitas penerapan kontrol keamanan terkait Pelindungan Data Pribadi (PDP).',
            ],
            [
                'tipe_evaluasi_id' => 3,
                'nama_evaluasi' => 'VIII Suplemen',
                'judul' => 'Bagian VIII: Suplemen',
                'deskripsi' => 'Bagian ini mengevaluasi kelengkapan, konsistensi dan efektivitas penerapan mekanisme keamanan terkait risiko keterlibatan pihak ketiga eksternal dalam operasional penyelenggaraan layanan instansi/perusahaan.',
            ],
        ];

        foreach ($daftarAreaEvaluasi as $areaEvaluasi) {
            AreaEvaluasi::create([
                'tipe_evaluasi_id' => $areaEvaluasi['tipe_evaluasi_id'],
                'nama_area_evaluasi' => $areaEvaluasi['nama_evaluasi'],
                'judul' => $areaEvaluasi['judul'],
                'deskripsi' => $areaEvaluasi['deskripsi'],
            ]);
        }
    }
}
