<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Evaluasi\AreaEvaluasiSeeder;
use Database\Seeders\Evaluasi\PertanyaanIKategoriSESeeder;
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
            AreaEvaluasiSeeder::class,
            PertanyaanIKategoriSESeeder::class,
        ]);
    }
}
