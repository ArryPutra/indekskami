<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Responden\StatusEvaluasi;
use App\Models\Responden\StatusProgresEvaluasi;
use Illuminate\Support\Facades\Auth;

class RedirectEvaluasiController extends Controller
{
    public function index()
    {
        $responden = Auth::user()->responden;

        // jika responden tidak memiliki akses evaluasi
        if (!$responden->akses_evaluasi) {
            return redirect()->route('responden.nonaktif-evaluasi');
        }

        $statusProgreEvaluasiResponden = $responden->statusProgresEvaluasi->status_progres_evaluasi;
        switch ($statusProgreEvaluasiResponden) {
            case StatusProgresEvaluasi::BELUM_MEMULAI:
                return redirect()->route('responden.evaluasi.identitas-responden.create');
                break;
            case StatusProgresEvaluasi::SEDANG_MENGERJAKAN:
                $hasilEvaluasiTerakhir = $responden->hasilEvaluasi->last();
                return redirect()->route('responden.evaluasi.pertanyaan', [1, $hasilEvaluasiTerakhir->id]);
                break;
            case StatusProgresEvaluasi::SELESAI_MENGERJAKAN:
                return redirect()->route('responden.selesai-evaluasi');
                break;
        }
    }
}
