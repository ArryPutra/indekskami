<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Evaluasi\AreaEvaluasiSeeder;
use Database\Seeders\Evaluasi\JudulTemaEvaluasiPertanyaanSeeder;
use Database\Seeders\Evaluasi\JudulTemaPertanyaanSeeder;
use Database\Seeders\Evaluasi\PertanyaanEvaluasiUtamaSeeder;
use Database\Seeders\Evaluasi\PertanyaanIKategoriSESeeder;
use Database\Seeders\Evaluasi\PertanyaanSuplemenSeeder;
use Database\Seeders\Evaluasi\TipeEvaluasiSeeder;
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
            RespondenSeeder::class,
            // VerifikatorSeeder::class,
            TipeEvaluasiSeeder::class,
            AreaEvaluasiSeeder::class,
            PertanyaanIKategoriSESeeder::class,
            PertanyaanEvaluasiUtamaSeeder::class,
            PertanyaanSuplemenSeeder::class,
            JudulTemaPertanyaanSeeder::class
        ]);
    }
}
