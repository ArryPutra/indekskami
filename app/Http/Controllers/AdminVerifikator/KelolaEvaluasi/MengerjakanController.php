<?php

namespace App\Http\Controllers\AdminVerifikator\KelolaEvaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Evaluasi\StatusHasilEvaluasi;

class MengerjakanController extends Controller
{
    public function index()
    {
        return view('pages.admin-verifikator.kelola-evaluasi.mengerjakan', [
            'title' => 'Mengerjakan Evaluasi',
            'daftarHasilEvaluasi' => HasilEvaluasi::with(['identitasResponden', 'responden.user'])
                ->where('status_hasil_evaluasi_id', StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID)->latest()->paginate(10)
        ]);
    }
}
