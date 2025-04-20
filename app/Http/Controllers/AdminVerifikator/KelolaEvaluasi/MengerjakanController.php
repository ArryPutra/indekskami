<?php

namespace App\Http\Controllers\AdminVerifikator\KelolaEvaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;

class MengerjakanController extends Controller
{
    public function index()
    {
        return view('pages.admin-verifikator.kelola-evaluasi.mengerjakan', [
            'title' => 'Mengerjakan Evaluasi',
            'daftarHasilEvaluasi' => HasilEvaluasi::with(['identitasResponden', 'responden.user'])->where('status', 'Dikerjakan')->latest()->paginate(10)
        ]);
    }
}
