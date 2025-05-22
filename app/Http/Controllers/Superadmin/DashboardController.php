<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Verifikator\Verifikator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.superadmin.dashboard', [
            'title' => 'Dashboard',
        ]);
    }
}
