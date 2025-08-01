<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class HasilEvaluasiExport implements FromView
{
    protected $responden;
    protected $hasilEvaluasi;
    protected $identitasResponden;
    protected $nilaiEvaluasi;
    protected $tingkatKelengkapanIso;
    protected $hasilEvaluasiAkhir;

    public function __construct(
        $responden,
        $hasilEvaluasi,
        $identitasResponden,
        $nilaiEvaluasi,
        $tingkatKelengkapanIso,
        $hasilEvaluasiAkhir
    ) {
        $this->responden = $responden;
        $this->hasilEvaluasi = $hasilEvaluasi;
        $this->identitasResponden = $identitasResponden;
        $this->nilaiEvaluasi = $nilaiEvaluasi;
        $this->tingkatKelengkapanIso = $tingkatKelengkapanIso;
        $this->hasilEvaluasiAkhir = $hasilEvaluasiAkhir;
    }

    public function view(): View
    {
        return view('exports.hasil-evaluasi', [
            'responden' => $this->responden,
            'hasilEvaluasi' => $this->hasilEvaluasi,
            'identitasResponden' => $this->identitasResponden,
            'nilaiEvaluasi' => $this->nilaiEvaluasi,
            'tingkatKelengkapanIso' => $this->tingkatKelengkapanIso,
            'hasilEvaluasiAkhir' => $this->hasilEvaluasiAkhir,
        ]);
    }
}
