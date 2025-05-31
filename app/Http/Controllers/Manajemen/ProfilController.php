<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pages.manajemen.profil', [
            'title' => 'Profil',
            'user' => Auth::user()
        ]);
    }
}
