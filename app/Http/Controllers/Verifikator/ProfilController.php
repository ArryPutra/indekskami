<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pages.verifikator.profil', [
            'title' => 'Profil',
            'user' => Auth::user()
        ]);
    }
}
