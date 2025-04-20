<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelolaEvaluasiController extends Controller
{
    public function index()
    {
        return view('pages.admin.kelola-evaluasi.index', [
            'title' => 'Kelola Evaluasi'
        ]);
    }
}
