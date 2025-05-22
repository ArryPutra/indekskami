<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Responden\HasilEvaluasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.verifikator.dashboard', [
            'title' => 'Dashboard',
            'daftarDataCard' => [
                'totalMengerjakanEvaluasi' => HasilEvaluasi::where('status_hasil_evaluasi_id', 1)->count()
            ]
        ]);
    }
}
