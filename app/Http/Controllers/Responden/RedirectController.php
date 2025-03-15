<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function index()
    {
        return redirect()->route('responden.daftar-identitas');
    }
}
