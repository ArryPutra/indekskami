<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.responden.profil', [
            'title' => 'Profil',
            'user' => $user,
            'responden' => $user->responden
        ]);
    }
}
