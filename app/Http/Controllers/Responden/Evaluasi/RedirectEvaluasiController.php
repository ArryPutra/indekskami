<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Responden\StatusEvaluasi;
use App\Models\Responden\StatusProgresEvaluasiResponden;
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

        $statusProgreEvaluasiResponden = $responden->statusProgresEvaluasiResponden->nama_status_progres_evaluasi_responden;
        switch ($statusProgreEvaluasiResponden) {
            case StatusProgresEvaluasiResponden::TIDAK_MENGERJAKAN:
                return redirect()->route('responden.evaluasi.identitas-responden.create');
                break;
            case StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN:
                $hasilEvaluasiRespondenDikerjakan =
                    $responden->hasilEvaluasi->where(
                        'status_hasil_evaluasi_id',
                        StatusHasilEvaluasi::where('nama_status_hasil_evaluasi', StatusHasilEvaluasi::STATUS_DIKERJAKAN)->value('id')
                    )->first();
                return redirect()->route('responden.evaluasi.pertanyaan', [1, $hasilEvaluasiRespondenDikerjakan->id]);
                break;
            case StatusProgresEvaluasiResponden::SELESAI_MENGERJAKAN:
                return redirect()->route('responden.evaluasi.selesai-evaluasi');
                break;
        }
    }
}
