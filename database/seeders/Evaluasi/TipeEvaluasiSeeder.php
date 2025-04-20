<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\TipeEvaluasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeEvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarTipeEvaluasi = [
            'Kategori Sistem Elektronik',
            'Evaluasi Utama',
            'Suplemen'
        ];

        foreach ($daftarTipeEvaluasi as $tipeEvaluasi) {
            TipeEvaluasi::create([
                'tipe_evaluasi' => $tipeEvaluasi
            ]);
        }
    }
}
