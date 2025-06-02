<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Manajemen\Manajemen;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Verifikator\Verifikator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total hasil evaluasi per tahun dari tabel HasilEvaluasi.
        $daftarTotalHasilEvaluasiTahunan = HasilEvaluasi::selectRaw('YEAR(created_at) as name, COUNT(*) as y')
            ->groupBy('name')
            ->orderBy('name')
            ->get();

        return view('pages.superadmin.dashboard', [
            'title' => 'Dashboard',
            'dataCard' => [
                // Data Pengguna
                'totalAdmin' => Admin::count(),
                'totalResponden' => Responden::count(),
                'totalVerifikator' => Verifikator::count(),
                'totalManajemen' => Manajemen::count(),
                // Data Pertanyaan
                'totalPertanyaan' => PertanyaanEvaluasi::count(),
            ],
            'daftarTotalHasilEvaluasiTahunan' => $daftarTotalHasilEvaluasiTahunan
        ]);
    }
}
