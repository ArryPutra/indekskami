<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.verifikator.dashboard', [
            'title' => 'Dashboard',
            'daftarDataCard' => [
                'totalMengerjakanEvaluasi' => HasilEvaluasi::where('status', 'Dikerjakan')->count()
            ]
        ]);
    }
}
