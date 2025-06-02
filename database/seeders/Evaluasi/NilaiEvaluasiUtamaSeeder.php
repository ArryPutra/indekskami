<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Responden\NilaiEvaluasiUtama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NilaiEvaluasiUtamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NilaiEvaluasiUtama::create([
            'area_evaluasi_id' => 2,
            'nama_nilai_evaluasi_utama' => NilaiEvaluasiUtama::NILAI_EVALUASI_UTAMA_TATA_KELOLA
        ]);
        NilaiEvaluasiUtama::create([
            'area_evaluasi_id' => 3,
            'nama_nilai_evaluasi_utama' => NilaiEvaluasiUtama::NILAI_EVALUASI_UTAMA_PENGELOLAAN_RISIKO
        ]);
        NilaiEvaluasiUtama::create([
            'area_evaluasi_id' => 4,
            'nama_nilai_evaluasi_utama' => NilaiEvaluasiUtama::NILAI_EVALUASI_UTAMA_KERANGKA_KERJA_KEAMANAN_INFORMASI
        ]);
        NilaiEvaluasiUtama::create([
            'area_evaluasi_id' => 5,
            'nama_nilai_evaluasi_utama' => NilaiEvaluasiUtama::NILAI_EVALUASI_UTAMA_PENGELOLAAN_ASET
        ]);
        NilaiEvaluasiUtama::create([
            'area_evaluasi_id' => 6,
            'nama_nilai_evaluasi_utama' => NilaiEvaluasiUtama::NILAI_EVALUASI_UTAMA_TEKNOLOGI_DAN_KEAMANAN_INFORMASI
        ]);
        NilaiEvaluasiUtama::create([
            'area_evaluasi_id' => 7,
            'nama_nilai_evaluasi_utama' => NilaiEvaluasiUtama::NILAI_EVALUASI_UTAMA_PERLINDUNGAN_DATA_PRIBADI
        ]);
    }
}
