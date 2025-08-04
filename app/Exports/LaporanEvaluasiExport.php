<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanEvaluasiExport implements WithMultipleSheets
{
    protected $hasilEvaluasi;

    public function __construct($hasilEvaluasi)
    {
        $this->hasilEvaluasi = $hasilEvaluasi;
    }

    public function sheets(): array
    {
        return [
            new IKategoriSeSheet($this->hasilEvaluasi),
            new IITataKelolaSheet($this->hasilEvaluasi),
            new IIIRisikoSheet($this->hasilEvaluasi),
            new IVKerangkaKerjaSheet($this->hasilEvaluasi),
            new VPengelolaanAsetSheet($this->hasilEvaluasi),
            new VITeknologiSheet($this->hasilEvaluasi),
            new VIIPDPSheet($this->hasilEvaluasi),
            new VIIISuplemenSheet($this->hasilEvaluasi),
            new DashboardSheet($this->hasilEvaluasi)
        ];
    }
}
