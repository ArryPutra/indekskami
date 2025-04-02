<?php

namespace App\Http\Controllers\Responden;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.responden.dashboard', [
            'title' => 'Dashboard'
        ]);
    }
}
