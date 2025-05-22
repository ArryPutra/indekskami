<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;
use App\Models\Responden\JawabanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Responden\StatusHasilEvaluasi;
use App\Models\Responden\StatusProgresEvaluasiResponden;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $responden = Auth::user()->responden;

        $statusProgresEvaluasiResponden =
            Auth::user()->responden->statusProgresEvaluasiResponden->nama_status_progres_evaluasi_responden;
        $isMengerjakanEvaluasi =
            $statusProgresEvaluasiResponden === StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN;

        $hasilEvaluasiDikerjakan = $responden->hasilEvaluasi->where(
            'status_hasil_evaluasi_id',
            StatusHasilEvaluasi::where('nama_status_hasil_evaluasi', StatusHasilEvaluasi::STATUS_DIKERJAKAN)->value('id')
        )->first();

        return view('pages.responden.dashboard', [
            'title' => 'Dashboard',
            'dataCard' => [
                'totalEvaluasiDikerjakan' => Auth::user()->responden->hasilEvaluasi()->count(),
            ],
            'statusProgresEvaluasiResponden' => $statusProgresEvaluasiResponden,
            'progresEvaluasiTerjawab' => $isMengerjakanEvaluasi ?
                HasilEvaluasi::getProgresEvaluasiTerjawab($hasilEvaluasiDikerjakan) : false,
        ]);
    }
}
