<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonaktifEvaluasiController extends Controller
{
    public function index()
    {
        if (Auth::user()->responden->akses_evaluasi) {
            return redirect()->route('responden.redirect-evaluasi');
        }
        return view('pages.responden.evaluasi.nonaktif-evaluasi', [
            'title' => 'Evaluasi'
        ]);
    }
}
