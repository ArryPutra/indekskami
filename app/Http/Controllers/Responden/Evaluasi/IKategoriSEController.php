<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IKategoriSEController extends Controller
{
    public function index()
    {
        return view('pages.responden.evaluasi.i-kategori-se', [
            'title' => 'Evaluasi'
        ]);
    }
}
