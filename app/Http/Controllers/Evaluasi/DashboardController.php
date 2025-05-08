<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\HasilEvaluasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(HasilEvaluasi $hasilEvaluasi)
    {
        return view('pages.evaluasi.dashboard', [
            'title' => 'Dashboard Evaluasi',
            'responden' => $hasilEvaluasi->responden,
            'hasilEvaluasi' => $hasilEvaluasi,
            'identitasResponden' => $hasilEvaluasi->identitasResponden,
            'daftarAreaEvaluasiUtama' => AreaEvaluasi::all()
        ]);
    }
}
