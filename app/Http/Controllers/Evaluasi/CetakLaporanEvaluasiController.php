<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\NilaiEvaluasiUtamaResponden;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\NilaiEvaluasi;
use Illuminate\Http\Request;

class CetakLaporanEvaluasiController extends Controller
{
    public function index(HasilEvaluasi $hasilEvaluasi)
    {
        $nilaiEvaluasi =
            $hasilEvaluasi->nilaiEvaluasi->with('nilaiEvaluasiUtamaResponden.nilaiEvaluasiUtama')->first();

        return view('pages.evaluasi.dashboard.cetak', [
            'title' => 'Cetak Laporan Evaluasi',
            'responden' => $hasilEvaluasi->responden,
            'hasilEvaluasi' => $hasilEvaluasi,
            'hasilEvaluasiId' => $hasilEvaluasi->id,
            'identitasResponden' => $hasilEvaluasi->identitasResponden,
            'nilaiEvaluasi' => $nilaiEvaluasi->load('nilaiEvaluasiUtamaResponden.nilaiEvaluasiUtama'),
            'hasilEvaluasiAkhir' => $this->getHasilEvaluasiAkhir($nilaiEvaluasi->hasil_evaluasi_akhir),
            'tingkatKelengkapanIso' => NilaiEvaluasi::getTingkatKelengkapanIso($nilaiEvaluasi->tingkat_kelengkapan_iso),
            'daftarNilaiEvaluasiUtama' => NilaiEvaluasiUtamaResponden::getNilaiEvaluasiUtama($nilaiEvaluasi->nilaiEvaluasiUtamaResponden),
        ]);
    }

    private function getHasilEvaluasiAkhir($hasilEvaluasiAkhir)
    {
        return match ($hasilEvaluasiAkhir) {
            NilaiEvaluasi::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK
            => [
                'color' => 'bg-red-600',
                'label' => NilaiEvaluasi::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK
            ],
            NilaiEvaluasi::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR
            => [
                'color' => 'bg-yellow-500',
                'label' => NilaiEvaluasi::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR
            ],
            NilaiEvaluasi::HASIL_EVALUASI_AKHIR_CUKUP_BAIK
            => [
                'color' => 'bg-lime-400',
                'label' => NilaiEvaluasi::HASIL_EVALUASI_AKHIR_CUKUP_BAIK
            ],
            NilaiEvaluasi::HASIL_EVALUASI_AKHIR_BAIK
            => [
                'color' => 'bg-lime-600',
                'label' => NilaiEvaluasi::HASIL_EVALUASI_AKHIR_BAIK
            ],
        };
    }
}
