<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\StatusHasilEvaluasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'status_hasil_evaluasi' => $statusHasilEvaluasi
            ]);
        }
    }
}
