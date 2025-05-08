<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Evaluasi\StatusHasilEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Verifikator\Verifikator;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'title' => 'Dashboard',
            'daftarDataCard' => [
                'totalResponden' => Responden::count(),
                'totalVerifikator' => Verifikator::count(),
                'totalMengerjakanEvaluasi' => HasilEvaluasi::where(
                    'status_hasil_evaluasi_id',
                    StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID
                )->count()
            ]
        ]);
    }
}
