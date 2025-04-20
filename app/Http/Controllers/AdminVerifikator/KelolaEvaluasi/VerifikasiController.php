<?php

namespace App\Http\Controllers\AdminVerifikator\KelolaEvaluasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        return view('pages.admin-verifikator.kelola-evaluasi.verifikasi', [
            'title' => 'Verifikasi Evaluasi'
        ]);
    }
}
