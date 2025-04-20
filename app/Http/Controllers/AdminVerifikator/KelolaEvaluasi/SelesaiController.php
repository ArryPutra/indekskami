<?php

namespace App\Http\Controllers\AdminVerifikator\KelolaEvaluasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelesaiController extends Controller
{
    public function index()
    {
        return view('pages.admin-verifikator.kelola-evaluasi.selesai', [
            'title' => 'Selesai Evaluasi'
        ]);
    }
}
