<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Responden\Responden;
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

        $statusEvaluasiResponden = $responden->status_evaluasi;
        switch ($statusEvaluasiResponden) {
            case Responden::STATUS_BELUM:
                return redirect()->route('responden.evaluasi.identitas-responden.create');
                break;
            case Responden::STATUS_MENGERJAKAN:
                $hasilEvaluasiTerakhir = $responden->hasilEvaluasi->last();
                return redirect()->route('responden.evaluasi.pertanyaan', [1, $hasilEvaluasiTerakhir->id]);
                break;
            case Responden::STATUS_SELESAI:
                return redirect()->route('responden.selesai-evaluasi');
                break;
        }
    }
}
