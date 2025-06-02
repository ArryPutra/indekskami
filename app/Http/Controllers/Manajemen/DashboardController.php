<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // #1 QUERY DATA
        $totalEvaluasiDiverifikasiQuery = HasilEvaluasi::where('status_hasil_evaluasi_id', StatusHasilEvaluasi::STATUS_DIVERIFIKASI_ID);
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

        // #2 FILTER DATA
        // Request tanggal mulai
        if (($requestTanggalMulai = request('tanggal-mulai')) && $requestTanggalMulai !== null) {
            $totalEvaluasiDiverifikasiQuery->where('tanggal_diverifikasi', '>=', $requestTanggalMulai);
            $daftarHasilEvaluasiQuery->where('tanggal_diverifikasi', '>=', $requestTanggalMulai);
        }
        // Request tanggal akhir
        if (($requestTanggalAkhir = request('tanggal-akhir')) && $requestTanggalAkhir !== null) {
            $requestTanggalAkhir = Carbon::parse($requestTanggalAkhir)->endOfDay();

            $totalEvaluasiDiverifikasiQuery->where('tanggal_diverifikasi', '<=', $requestTanggalAkhir);
            $daftarHasilEvaluasiQuery->where('tanggal_diverifikasi', '<=', $requestTanggalAkhir);
        }

        // Request kategori se
        if (($requestKategoriSe = request('kategori-se')) && $requestKategoriSe !== 'semua') {
            $daftarHasilEvaluasiQuery
                ->whereHas(
                    'nilaiEvaluasi',
                    function ($query) use ($requestKategoriSe) {
                        $query->where('kategori_se', $requestKategoriSe);
                    }
                );
        }

        // #3 TAMPILKAN DATA
        $totalEvaluasiDiverifikasi = $totalEvaluasiDiverifikasiQuery->count();
        $daftarRespondenChartEvaluasiDiverifikasi = $daftarHasilEvaluasiQuery
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->responden->user->nama,
                    'y' => $item->nilaiEvaluasi->tingkat_kelengkapan_iso,
                    'tanggal_diverifikasi' => Carbon::parse($item->tanggal_diverifikasi)->translatedFormat('l, d F Y, H:i:s'),
                ];
            })
            ->sortByDesc('y')
            // ->take(5)
            ->values();

        return view('pages.manajemen.dashboard', [
            'title' => 'Dashboard',
            'daftarRespondenChartEvaluasiDiverifikasi' => $daftarRespondenChartEvaluasiDiverifikasi,
            'dataCard' => [
                'totalEvaluasiDiverifikasi' => $totalEvaluasiDiverifikasi,
            ],
            'daftarEvaluasiDiverifikasi' => $daftarHasilEvaluasiQuery
                ->orderBy('tanggal_diverifikasi', 'desc')
                ->paginate(10)
                ->appends(request()->query())
        ]);
    }
}
