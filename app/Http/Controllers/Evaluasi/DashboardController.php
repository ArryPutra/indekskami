<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(HasilEvaluasi $hasilEvaluasi)
    {
        return view('pages.evaluasi.dashboard', [
            'title' => 'Dashboard Evaluasi',
            'hasilEvaluasi' => $hasilEvaluasi,
            'hasilEvaluasiId' => $hasilEvaluasi->id,
            'identitasResponden' => $hasilEvaluasi->identitasResponden,
            'identitasRespondenId' => $hasilEvaluasi->identitasResponden->id
        ]);
    }
}
