<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.verifikator.dashboard', [
            'title' => 'Dashboard',
            'dataCard' => [
                'totalDitinjau' => HasilEvaluasi::where(
                    'status_hasil_evaluasi_id',
                    StatusHasilEvaluasi::STATUS_DITINJAU_ID
                )->count(),
                'totalMengerjakan' => HasilEvaluasi::where(
                    'status_hasil_evaluasi_id',
                    StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID
                )->count(),
                'totalDiverifikasi' => HasilEvaluasi::where(
                    'status_hasil_evaluasi_id',
                    StatusHasilEvaluasi::STATUS_DIVERIFIKASI_ID
                )->count(),
            ]
        ]);
    }
}
