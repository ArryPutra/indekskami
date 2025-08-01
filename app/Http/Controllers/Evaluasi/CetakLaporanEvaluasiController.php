<?php

namespace App\Http\Controllers\Evaluasi;

use App\Exports\HasilEvaluasiExport;
use App\Http\Controllers\Controller;
use App\Models\Responden\NilaiEvaluasiUtamaResponden;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\NilaiEvaluasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CetakLaporanEvaluasiController extends Controller
{
    public function index(HasilEvaluasi $hasilEvaluasi)
    {
        $nilaiEvaluasi =
            $hasilEvaluasi->nilaiEvaluasi->load('nilaiEvaluasiUtamaResponden.nilaiEvaluasiUtama');

        return view('pages.evaluasi.dashboard.cetak', [
            'title' => 'Cetak Laporan Evaluasi',
            'responden' => $hasilEvaluasi->responden,
            'hasilEvaluasi' => $hasilEvaluasi,
            'statusHasilEvaluasiSaatIni' => $hasilEvaluasi->statusHasilEvaluasi->nama_status_hasil_evaluasi,
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

    public function exportExcel(HasilEvaluasi $hasilEvaluasi)
    {
        $nilaiEvaluasi = $hasilEvaluasi->nilaiEvaluasi->load('nilaiEvaluasiUtamaResponden.nilaiEvaluasiUtama');
        $hasilEvaluasiAkhir = $this->getHasilEvaluasiAkhir($nilaiEvaluasi->hasil_evaluasi_akhir);
        $tingkatKelengkapanIso = NilaiEvaluasi::getTingkatKelengkapanIso($nilaiEvaluasi->tingkat_kelengkapan_iso);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\HasilEvaluasiExport(
                $hasilEvaluasi->responden,
                $hasilEvaluasi,
                $hasilEvaluasi->identitasResponden,
                $nilaiEvaluasi,
                $tingkatKelengkapanIso,
                $hasilEvaluasiAkhir
            ),
            'laporan-hasil-evaluasi.xlsx'
        );
    }
}
