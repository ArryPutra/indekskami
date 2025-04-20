<?php

namespace App\Http\Controllers\Admin\KelolaPertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use Illuminate\Http\Request;

class KelolaJudulTemaPertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areaEvaluasiId = session('areaEvaluasiId');

        return view('pages.admin.kelola-pertanyaan.kelola-tema-judul-pertanyaan.index', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasiId' => $areaEvaluasiId,
            'namaAreaEvaluasi' => AreaEvaluasi::find($areaEvaluasiId)->nama_evaluasi,
            'daftarJudulTemaPertanyaan' => JudulTemaPertanyaan::where('area_evaluasi_id', $areaEvaluasiId)
                ->orderBy('letakkan_sebelum_nomor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.kelola-pertanyaan.kelola-tema-judul-pertanyaan.form', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasiId' => session('areaEvaluasiId'),
            'judulTemaPertanyaan' => new JudulTemaPertanyaan(),
            'pageMeta' => [
                'route' => route('kelola-judul-tema-pertanyaan.store'),
                'method' => 'POST'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $judulTemaPertanyaanBaru = $request->validate([
            'judul' => ['required', 'max:255'],
            'letakkan_sebelum_nomor' => ['required', 'numeric']
        ]);

        $areaEvaluasiId = session('areaEvaluasiId');

        JudulTemaPertanyaan::create([
            'area_evaluasi_id' => $areaEvaluasiId,
            'judul' => $judulTemaPertanyaanBaru['judul'],
            'letakkan_sebelum_nomor' => $judulTemaPertanyaanBaru['letakkan_sebelum_nomor']
        ]);

        return redirect()->route('kelola-judul-tema-pertanyaan.index')->with('success', 'Judul tema pertanyaan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $judulTemaPertanyaanId)
    {
        return view('pages.admin.kelola-pertanyaan.kelola-tema-judul-pertanyaan.form', [
            'title' => 'Kelola Pertanyaan',
            'judulTemaPertanyaan' => JudulTemaPertanyaan::find($judulTemaPertanyaanId),
            'pageMeta' => [
                'route' => route('kelola-judul-tema-pertanyaan.update', $judulTemaPertanyaanId),
                'method' => 'PUT'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $judulTemaPertanyaanId)
    {
        $judulTemaPertanyaanBaru = $request->validate([
            'judul' => ['required', 'max:255'],
            'letakkan_sebelum_nomor' => ['required', 'numeric']
        ]);

        $judulTemaPertanyaan = JudulTemaPertanyaan::find($judulTemaPertanyaanId);
        $judulTemaPertanyaan->update([
            'judul' => $judulTemaPertanyaanBaru['judul'],
            'letakkan_sebelum_nomor' => $judulTemaPertanyaanBaru['letakkan_sebelum_nomor']
        ]);

        return redirect()->route('kelola-judul-tema-pertanyaan.index')->with('success', 'Judul tema pertanyaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $judulTemaPertanyaanId)
    {
        $judulTemaPertanyaan = JudulTemaPertanyaan::find($judulTemaPertanyaanId);

        $judulTemaPertanyaan->delete();

        return redirect()->route('kelola-judul-tema-pertanyaan.index')->with('success', "Judul tema pertanyaan berhasil dihapus!");
    }
}
