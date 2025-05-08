<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Responden\StatusProgresEvaluasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusProgresEvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (StatusProgresEvaluasi::getStatusProgresEvaluasiOptions() as $statusProgresEvaluasi) {
            StatusProgresEvaluasi::create([
                'status_progres_evaluasi' => $statusProgresEvaluasi
            ]);
        }
    }
}
