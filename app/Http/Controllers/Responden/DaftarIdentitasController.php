<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarIdentitasController extends Controller
{
    public function index()
    {
        return view('pages.responden.daftar-identitas', [
            'title' => 'Daftar Identitas'
        ]);
    }
}
