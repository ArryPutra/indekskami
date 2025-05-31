<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            )->with(['identitasResponden', 'responden.user', 'nilaiEvaluasi'])
                ->orderBy('tanggal_diserahkan')->paginate(10)
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
            )->with(['identitasResponden', 'responden.user', 'nilaiEvaluasi'])->latest()->paginate(10)
        ]);
    }

    public function evaluasiSelesai()
    {
        $daftarHasilEvaluasiQuery = HasilEvaluasi::with(
            'identitasResponden',
            'responden.user',
            'nilaiEvaluasi',
            'verifikator'
        )
            ->where(
                'status_hasil_evaluasi_id',
                StatusHasilEvaluasi::STATUS_DIVERIFIKASI_ID
            );

        // Request cari
        if ($requestCari = request('cari')) {
            $daftarHasilEvaluasiQuery->whereHas(
                'responden.user',
                function ($query) use ($requestCari) {
                    $query->where('nama', 'like', '%' . $requestCari . '%')
                        ->orWhere('username', 'like', '%' . $requestCari . '%')
                        ->orWhere('email', 'like', '%' . $requestCari . '%')
                        ->orWhere('nomor_telepon', 'like', '%' . $requestCari . '%');
                }
            );
        }

        // Request diverifikasi oleh
        if (($requestDiverifikasi = request('diverifikasi')) && $requestDiverifikasi !== 'semua') {
            $daftarHasilEvaluasiQuery->where('verifikator_id', Auth::user()->verifikator->id);
        }
        // Request kategori se
        if (($requestKategoriSe = request('kategori-se')) && $requestKategoriSe !== 'semua') {
            $daftarHasilEvaluasiQuery->whereHas(
                'nilaiEvaluasi',
                function ($query) use ($requestKategoriSe) {
                    $query->where('kategori_se', $requestKategoriSe);
                }
            );
        }

        $daftarHasilEvaluasi = $daftarHasilEvaluasiQuery
            ->orderBy('tanggal_diverifikasi', 'desc')
            ->paginate(10)
            ->appends([
                'diverifikasi' => request('diverifikasi'),
                'kategori-se' => request('kategori-se'),
            ]);

        return view('pages.verifikator.kelola-evaluasi.evaluasi-selesai', [
            'title' => 'Evaluasi Selesai',
            'daftarHasilEvaluasi' => $daftarHasilEvaluasi
        ]);
    }
}
