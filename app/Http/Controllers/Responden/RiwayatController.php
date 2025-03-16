<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        return view('pages.responden.riwayat', [
            'title' => 'Riwayat'
        ]);
    }
}
