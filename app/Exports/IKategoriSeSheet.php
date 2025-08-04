<?php

namespace App\Exports;

use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanKategoriSe;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class IKategoriSeSheet implements FromView, WithTitle
{
    protected $hasilEvaluasi;

    public function __construct(
        $hasilEvaluasi,
    ) {
        $this->hasilEvaluasi = $hasilEvaluasi;
    }

    public function view(): View
    {
        $daftarPertanyaan = AreaEvaluasi::find(1)->pertanyaanEvaluasi;

        $daftarJawaban = $this->hasilEvaluasi->jawabanEvaluasi;

        $daftarPertanyaanDanJawaban = [];

        foreach ($daftarPertanyaan as $pertanyaan) {
            $jawaban = $daftarJawaban->where('pertanyaan_evaluasi_id', $pertanyaan->id)->first();
            $statusJawaban = $jawaban?->status_jawaban;

            $status = PertanyaanKategoriSe::where(
                'pertanyaan_evaluasi_id',
                $pertanyaan->id
            )->first()[$statusJawaban] ?? null;
            $skor = PertanyaanKategoriSe::where(
                'pertanyaan_evaluasi_id',
                $pertanyaan->id
            )->first()['skor_' . $statusJawaban] ?? null;

            $daftarPertanyaanDanJawaban[] =
                [
                    'nomor' => $pertanyaan->nomor,
                    'pertanyaan' => $pertanyaan->pertanyaan,
                    'status' => $status,
                    'skor' => $skor,
                    'dokumen' => request()->getSchemeAndHttpHost() . '/file/' . $jawaban?->bukti_dokumen,
                    'keterangan' => $jawaban?->keterangan,
                ];
        }

        return view('exports.pertanyaan', [
            'hasilEvaluasi' => $this->hasilEvaluasi,
            'daftarPertanyaanDanJawaban' => $daftarPertanyaanDanJawaban,
            'title' => 'I Kategori SE',
        ]);
    }

    public function title(): string
    {
        return 'I Kategori SE';
    }
}
