<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.manajemen.dashboard', [
            'title' => 'Dashboard',
        ]);
    }
}
