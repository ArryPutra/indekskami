<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesanEvaluasiController extends Controller
{
    public function index()
    {
        abort_if(session('pesanEvaluasi') === null, 404);

        return view('pages.responden.evaluasi.pesan-evaluasi', [
            'title' => session('title'),
            'pesanEvaluasi' => session('pesanEvaluasi'),
        ]);
    }
}
