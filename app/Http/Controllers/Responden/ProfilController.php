<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pages.responden.profil', [
            'title' => 'Profil'
        ]);
    }
}
