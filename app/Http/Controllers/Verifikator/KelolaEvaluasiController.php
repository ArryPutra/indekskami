<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use Illuminate\Http\Request;

class KelolaEvaluasiController extends Controller
{
    public function perluDitinjau()
    {
        return view('pages.verifikator.kelola-evaluasi.perlu-ditinjau', [
            'title' => 'Perlu Ditinjau',
            'daftarHasilEvaluasi' =>
            HasilEvaluasi::where(
                'status_hasil_evaluasi_id',
                StatusHasilEvaluasi::where('nama_status_hasil_evaluasi', StatusHasilEvaluasi::STATUS_DITINJAU)->value('id')
            )->latest()->with(['identitasResponden', 'responden.user', 'nilaiEvaluasi'])->paginate(10)
        ]);
    }

    public function sedangMengerjakan()
    {
        return view('pages.verifikator.kelola-evaluasi.sedang-mengerjakan', [
            'title' => 'Sedang Mengerjakan',
            'daftarHasilEvaluasi' =>
            HasilEvaluasi::where(
                'status_hasil_evaluasi_id',
                StatusHasilEvaluasi::where('nama_status_hasil_evaluasi', StatusHasilEvaluasi::STATUS_DIKERJAKAN)->value('id')
            )->latest()->with(['identitasResponden', 'responden.user', 'nilaiEvaluasi'])->paginate(10)
        ]);
    }

    public function evaluasiSelesai()
    {
        return view('pages.verifikator.kelola-evaluasi.evaluasi-selesai', [
            'title' => 'Evaluasi Selesai',
            'daftarHasilEvaluasi' =>
            HasilEvaluasi::where(
                'status_hasil_evaluasi_id',
                StatusHasilEvaluasi::where('nama_status_hasil_evaluasi', StatusHasilEvaluasi::STATUS_DIVERIFIKASI)->value('id')
            )->latest()->with(['identitasResponden', 'responden.user', 'nilaiEvaluasi'])->paginate(10)
        ]);
    }
}
