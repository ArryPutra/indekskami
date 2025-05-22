<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pages.admin.profil', [
            'title' => 'Profil',
            'user' => Auth::user()
        ]);
    }
}
