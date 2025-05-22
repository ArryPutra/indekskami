<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;
use App\Models\Responden\Responden;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $responden = Auth::user()->responden->load([
            'hasilEvaluasi' => fn($query) => $query->latest(),
            'hasilEvaluasi.identitasResponden',
            'hasilEvaluasi.nilaiEvaluasi'
        ]);

        return view('pages.responden.riwayat', [
            'title' => 'Riwayat',
            'daftarHasilEvaluasi' => $responden->hasilEvaluasi,
        ]);
    }
}
