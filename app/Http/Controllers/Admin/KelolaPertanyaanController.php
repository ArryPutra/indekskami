<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\JudulTemaEvaluasiPertanyaan;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use Illuminate\Http\Request;

class KelolaPertanyaanController extends Controller
{

    public function index() {}

    public function edit(AreaEvaluasi $areaEvaluasi) {}

    public function updateAreaEvaluasi(Request $request, string $id) {}

    public function updateJudulTemaPertanyaan(Request $request)
    {
        $daftarRequestJudulTemaPertanyaan = $request->except('_token');

        foreach ($daftarRequestJudulTemaPertanyaan as $judulTemaPertanyaanId => $judulTemaPertanyaanBaru) {
            $judulTemaPertanyaanLama = JudulTemaPertanyaan::find($judulTemaPertanyaanId);

            $judulTemaPertanyaanLama->update([
                'judul' => $judulTemaPertanyaanBaru['judul'],
                'sebelum_nomor' => $judulTemaPertanyaanBaru['sebelum_nomor']
            ]);
        }

        return redirect()->back()->with('successUpdateJudulTemaPertanyaan', 'Data judul tema pertanyaan berhasil diperbarui!');
    }
    public function storeJudulTemaPertanyaan() {}
    public function destroyJudulTemaPertanyaan(JudulTemaPertanyaan $judulTemaPertanyaan)
    {
        return $judulTemaPertanyaan;
    }

    public function updatePertanyaan(Request $request, string $id)
    {
        $request->validate([
            'nomor' => ['required'],
            'pertanyaan' => ['required', 'max:255'],
            'status_a' => ['required', 'max:255'],
            'status_b' => ['required', 'max:255'],
            'status_c' => ['required', 'max:255'],
            'skor_status_a' => ['required', 'numeric'],
            'skor_status_b' => ['required', 'numeric'],
            'skor_status_c' => ['required', 'numeric']
        ]);

        $pertanyaanId = $request['pertanyaan_id'];

        $pertanyaanBaru = $request()->except(['_token', 'pertanyaan_id']);
        $pertanyaanLama = PertanyaanIKategoriSE::find($pertanyaanId);

        $pertanyaanLama->update([
            'nomor' => $pertanyaanBaru->nomor,
            'pertanyaan' => $pertanyaanBaru->pertanyaan,
            'status_a' => $pertanyaanBaru->status_a,
            'status_b' => $pertanyaanBaru->status_b,
            'status_c' => $pertanyaanBaru->status_c,
            'skor_status_a' => $pertanyaanBaru->skor_status_a,
            'skor_status_b' => $pertanyaanBaru->skor_status_b,
            'skor_status_c' => $pertanyaanBaru->skor_status_c
        ]);

        return redirect()->back()->with('successUpdatePertanyaan', 'Data pertanyaan berhasil diperbarui!');
    }
}
