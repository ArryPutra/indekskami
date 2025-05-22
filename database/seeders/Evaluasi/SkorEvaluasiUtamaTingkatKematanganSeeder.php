<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\SkorEvaluasiUtamaTingkatKematangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkorEvaluasiUtamaTingkatKematanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SkorEvaluasiUtamaTingkatKematangan::create([
            'area_evaluasi_id' => 2,
            'skor_minimum_tingkat_kematangan_ii' => (4 * 2) + (4 * 1),
            'skor_pencapaian_tingkat_kematangan_ii' => (8 * 2) + (5 * 4),
            'skor_minimum_tingkat_kematangan_iii' => (2 * 2) + (1 * 4),
            'skor_pencapaian_tingkat_kematangan_iii' => (2 * 4) + (1 * 6),
            'skor_minimum_tingkat_kematangan_iv' => (2 * 6) + (4 * 3),
            'skor_pencapaian_tingkat_kematangan_iv' => 6 * 9,
        ]);

        SkorEvaluasiUtamaTingkatKematangan::create([
            'area_evaluasi_id' => 3,
            'skor_minimum_tingkat_kematangan_ii' => (4 * 2) + (6 * 1),
            'skor_pencapaian_tingkat_kematangan_ii' => (10 * 2),
            'skor_minimum_tingkat_kematangan_iii' => (2 * 2) + (0 * 4),
            'skor_pencapaian_tingkat_kematangan_iii' => 2 * 4,
            'skor_minimum_tingkat_kematangan_iv' => 2 * 4,
            'skor_pencapaian_tingkat_kematangan_iv' => 2 * 6,
            'skor_minimum_tingkat_kematangan_v' => 2 * 6,
            'skor_pencapaian_tingkat_kematangan_v' => 2 * 9,
        ]);

        SkorEvaluasiUtamaTingkatKematangan::create([
            'area_evaluasi_id' => 4,
            'skor_minimum_tingkat_kematangan_ii' => (4 * 2) + (7 * 1),
            'skor_pencapaian_tingkat_kematangan_ii' => (10 * 2) + (1 * 4),
            'skor_minimum_tingkat_kematangan_iii' => (4 * 3) + (3 * 2) + (5 * 4) + (4 * 3) + (1 * 6),
            'skor_pencapaian_tingkat_kematangan_iii' => (4 * 3) + (3 * 4) + (5 * 6) + (5 * 6),
            'skor_minimum_tingkat_kematangan_iv' => (2 * 6) + (1 * 3),
            'skor_pencapaian_tingkat_kematangan_iv' => (3 * 9),
            'skor_minimum_tingkat_kematangan_v' => 2 * 6,
            'skor_pencapaian_tingkat_kematangan_v' => 2 * 9,
        ]);

        SkorEvaluasiUtamaTingkatKematangan::create([
            'area_evaluasi_id' => 5,
            'skor_minimum_tingkat_kematangan_ii' => (7 * 2) + (25 * 1),
            'skor_pencapaian_tingkat_kematangan_ii' => (20 * 2) + (12 * 4),
            'skor_minimum_tingkat_kematangan_iii' => (4 * 2) + (6 * 4) + (5 * 3) + (6 * 6),
            'skor_pencapaian_tingkat_kematangan_iii' => (4 * 4) + (10 * 6) + (7 * 6),
        ]);

        SkorEvaluasiUtamaTingkatKematangan::create([
            'area_evaluasi_id' => 6,
            'skor_minimum_tingkat_kematangan_ii' => (4 * 2) + (10 * 1),
            'skor_pencapaian_tingkat_kematangan_ii' => 14 * 2,
            'skor_minimum_tingkat_kematangan_iii' => (2 * 2) + (16 * 4),
            'skor_pencapaian_tingkat_kematangan_iii' => (8 * 4) + (7 * 6) + (3 * 6),
            'skor_minimum_tingkat_kematangan_iv' => 1 * 6 + 2 * 3,
            'skor_pencapaian_tingkat_kematangan_iv' => 2 * 6 + 1 * 9,
        ]);

        SkorEvaluasiUtamaTingkatKematangan::create([
            'area_evaluasi_id' => 7,
            'skor_minimum_tingkat_kematangan_ii' => (2 * 2) + (4 * 1),
            'skor_pencapaian_tingkat_kematangan_ii' => 4 * 2 + 2 * 4,
            'skor_minimum_tingkat_kematangan_iii' => (2 * 2) + (8 * 4),
            'skor_pencapaian_tingkat_kematangan_iii' => (6 * 4) + (4 * 6),
        ]);
    }
}
