<?php

namespace Database\Seeders\Responden;

use App\Models\Responden\StatusProgresEvaluasiResponden;
use Illuminate\Database\Seeder;

class StatusProgresEvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (
            StatusProgresEvaluasiResponden::getStatusProgresEvaluasiRespondenOptions()
            as $statusProgresEvaluasiResponden
        ) {
            StatusProgresEvaluasiResponden::create([
                'nama_status_progres_evaluasi_responden' => $statusProgresEvaluasiResponden
            ]);
        }
    }
}
