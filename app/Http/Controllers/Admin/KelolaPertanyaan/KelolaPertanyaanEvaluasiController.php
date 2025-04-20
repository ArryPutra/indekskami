<?php

namespace App\Http\Controllers\Admin\KelolaPertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KelolaPertanyaanEvaluasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areaEvaluasiId = (int) session('areaEvaluasiId');
        $areaEvaluasi = AreaEvaluasi::find($areaEvaluasiId);

        // Ambil daftar pertanyaan berdasarkan area evaluasi id
        $daftarPertanyaan = match ($areaEvaluasiId) {
            1 => PertanyaanIKategoriSE::all(),
            2 => PertanyaanEvaluasiUtama::where('area_evaluasi_id', $areaEvaluasiId)->get(),
            default => collect()
        };

        return view('pages.admin.kelola-pertanyaan.kelola-pertanyaan-evaluasi.index', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasiId' => $areaEvaluasiId,
            'namaAreaEvaluasi' => $areaEvaluasi->nama_evaluasi,
            'daftarPertanyaan' => $daftarPertanyaan,
            'tipeEvaluasi' => $areaEvaluasi->tipeEvaluasi->tipe_evaluasi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $pertanyaanId)
    {
        $areaEvaluasiId = (int) session('areaEvaluasiId');
        $areaEvaluasi = AreaEvaluasi::find($areaEvaluasiId);

        return view('pages.admin.kelola-pertanyaan.kelola-pertanyaan-evaluasi.form', [
            'title' => 'Kelola Pertanyaan',
            'tipeEvaluasi' => $areaEvaluasi->tipeEvaluasi->tipe_evaluasi,
            'pertanyaan' => $this->getPertanyaan($areaEvaluasiId, $pertanyaanId),
            'pageMeta' => [
                'route' => route('kelola-pertanyaan-evaluasi.update', $pertanyaanId),
                'method' => 'PUT'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $pertanyaanId)
    {
        $areaEvaluasiId = (int) session('areaEvaluasiId');
        $tipeEvaluasiTable = match ($areaEvaluasiId) {
            1 => 'pertanyaan_i_kategori_se',
            2 => 'pertanyaan_evaluasi_utama',
            default => null
        };

        $request->validate([
            'nomor' => [
                'required',
                'numeric',
                Rule::unique($tipeEvaluasiTable, 'nomor')
                    ->where(fn($query) => $query->where('area_evaluasi_id', $areaEvaluasiId))
                    ->ignore($pertanyaanId)
            ],
            'tingkat_kematangan' => ['required', Rule::in(PertanyaanEvaluasiUtama::getTingkatKematanganOptions())],
            'pertanyaan' => ['required'],
        ]);

        $this->getPertanyaan($areaEvaluasiId, $pertanyaanId)->update([
            'nomor' => $request['nomor'],
            'tingkat_kematangan' => $request['tingkat_kematangan'] ?? null,
            'pertanyaan_tahap' => $request['pertanyaan_tahap'] ?? null,
            'pertanyaan' => $request['pertanyaan'],
            'status_pertama' => $request['status_pertama'],
            'status_kedua' => $request['status_kedua'],
            'status_ketiga' => $request['status_ketiga'],
            'status_keempat' => $request['status_keempat'],
            'status_kelima' => $request['status_kelima'],
            'skor_status_pertama' => $request['skor_status_pertama'],
            'skor_status_kedua' => $request['skor_status_kedua'],
            'skor_status_ketiga' => $request['skor_status_ketiga'],
            'skor_status_keempat' => $request['skor_status_keempat'],
            'skor_status_kelima' => $request['skor_status_kelima']
        ]);

        return redirect()->route('kelola-pertanyaan-evaluasi.index')->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getPertanyaan($areaEvaluasiId, $pertanyaanId)
    {
        return $pertanyaan = match ($areaEvaluasiId) {
            1 => PertanyaanIKategoriSE::find($pertanyaanId),
            2 => PertanyaanEvaluasiUtama::find($pertanyaanId),
            default => null
        };
    }
}
