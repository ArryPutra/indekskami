<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;
use App\Models\Responden\Responden;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function index()
    {
        $statusEvaluasiResponden = Auth::user()->responden->status_evaluasi;

        switch ($statusEvaluasiResponden) {
            case Responden::STATUS_BELUM:
                return redirect()->route('responden.identitas-responden');
                break;
            case Responden::STATUS_MENGERJAKAN:
                return redirect()->route('responden.evaluasi.i-kategori-se');
                break;
                // case Responden::STATUS_SELESAI:
                //     return redirect()->route('responden.evaluasi.i-kategori-se');
                //     break;
        }
    }
}