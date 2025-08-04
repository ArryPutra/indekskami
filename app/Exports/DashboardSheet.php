<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class DashboardSheet implements FromView, WithTitle
{
    protected $responden;
    protected $hasilEvaluasi;
    protected $identitasResponden;
    protected $nilaiEvaluasi;

    public function __construct(
        $hasilEvaluasi,
    ) {
        $this->hasilEvaluasi = $hasilEvaluasi;

        $this->responden = $hasilEvaluasi->responden;
        $this->identitasResponden = $hasilEvaluasi->identitasResponden;
        $this->nilaiEvaluasi = $hasilEvaluasi->nilaiEvaluasi;
    }

    public function view(): View
    {
        return view('exports.dashboard', [
            'responden' => $this->responden,
            'hasilEvaluasi' => $this->hasilEvaluasi,
            'identitasResponden' => $this->identitasResponden,
            'nilaiEvaluasi' => $this->nilaiEvaluasi,
        ]);
    }

    public function title(): string
    {
        return 'Dashboard';
    }
}
