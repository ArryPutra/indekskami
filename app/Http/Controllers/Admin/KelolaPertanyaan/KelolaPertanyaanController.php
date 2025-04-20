<?php

namespace App\Http\Controllers\Admin\KelolaPertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use Illuminate\Http\Request;

class KelolaPertanyaanController extends Controller
{
    public function index()
    {
        return view('pages.admin.kelola-pertanyaan.index', [
            'title' => 'Kelola Pertanyaan',
            'daftarAreaEvaluasi' => AreaEvaluasi::all(),
        ]);
    }
}
