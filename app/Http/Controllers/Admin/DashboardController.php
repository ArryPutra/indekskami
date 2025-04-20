<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
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
                'totalMengerjakanEvaluasi' => HasilEvaluasi::where('status', 'Dikerjakan')->count()
            ]
        ]);
    }
}
