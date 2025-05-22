<?php

namespace Database\Seeders\Responden;

use App\Models\Responden\StatusHasilEvaluasi;
use Illuminate\Database\Seeder;

class StatusHasilEvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (StatusHasilEvaluasi::getStatusHasilEvaluasiOptions() as $statusHasilEvaluasi) {
            StatusHasilEvaluasi::create([
                'nama_status_hasil_evaluasi' => $statusHasilEvaluasi
            ]);
        }
    }
}
