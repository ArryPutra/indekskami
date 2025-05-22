<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelesaiEvaluasiController extends Controller
{
    public function index()
    {
        return view('pages.responden.evaluasi.selesai-evaluasi', [
            'title' => 'Selesai Evaluasi'
        ]);
    }
}
