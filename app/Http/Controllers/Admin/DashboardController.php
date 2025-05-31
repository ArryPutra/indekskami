<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Manajemen\Manajemen;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Verifikator\Verifikator;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'title' => 'Dashboard',
            'dataCard' => [
                'totalAdmin' => Admin::count(),
                'totalResponden' => Responden::count(),
                'totalVerifikator' => Verifikator::count(),
                'totalManajemen' => Manajemen::count(),
            ]
        ]);
    }
}
