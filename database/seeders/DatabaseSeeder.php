<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Evaluasi\StatusHasilEvaluasi;
use App\Models\Responden\StatusProgresEvaluasi;
use Database\Seeders\Evaluasi\AreaEvaluasiSeeder;
use Database\Seeders\Evaluasi\JudulTemaEvaluasiPertanyaanSeeder;
use Database\Seeders\Evaluasi\JudulTemaPertanyaanSeeder;
use Database\Seeders\Evaluasi\PertanyaanEvaluasiUtamaSeeder;
use Database\Seeders\Evaluasi\PertanyaanIKategoriSESeeder;
use Database\Seeders\Evaluasi\PertanyaanKategoriSeSeeder;
use Database\Seeders\Evaluasi\PertanyaanSuplemenSeeder;
use Database\Seeders\Evaluasi\StatusHasilEvaluasiSeeder;
use Database\Seeders\Evaluasi\TipeEvaluasiSeeder;
use Database\Seeders\Responden\RespondenSeeder;
use Database\Seeders\Responden\StatusEvaluasiSeeder;
use Database\Seeders\Responden\StatusProgresEvaluasiSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PeranSeeder::class,
            UserSeeder::class,
            StatusProgresEvaluasiSeeder::class,
            RespondenSeeder::class,
            VerifikatorSeeder::class,
            TipeEvaluasiSeeder::class,
            AreaEvaluasiSeeder::class,
            PertanyaanKategoriSeSeeder::class,
            PertanyaanEvaluasiUtamaSeeder::class,
            PertanyaanSuplemenSeeder::class,
            JudulTemaPertanyaanSeeder::class,
            StatusHasilEvaluasiSeeder::class
        ]);
    }
}
