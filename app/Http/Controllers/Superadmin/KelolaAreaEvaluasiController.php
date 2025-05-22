<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\TipeEvaluasi;
use Illuminate\Http\Request;

class KelolaAreaEvaluasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.superadmin.kelola-pertanyaan.kelola-area-evaluasi.index', [
            'title' => 'Kelola Pertanyaan',
            'daftarAreaEvaluasi' => AreaEvaluasi::all(),
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
    public function edit(string $areaEvaluasiId)
    {
        // Store areaEvaluasiId ke session untuk keperluan redirect
        session(['areaEvaluasiId' => $areaEvaluasiId]);

        $areaEvaluasi = AreaEvaluasi::findOrFail($areaEvaluasiId);

        return view('pages.superadmin.kelola-pertanyaan.kelola-area-evaluasi.edit', [
            'title' => 'Kelola Pertanyaan',
            'namaTipeEvaluasi' => $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi,
            'areaEvaluasi' => $areaEvaluasi,
            'areaEvaluasiId' => $areaEvaluasiId,
            'namaAreaEvaluasi' => $areaEvaluasi->nama_area_evaluasi,
            'isEvaluasiUtama' => $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi === TipeEvaluasi::EVALUASI_UTAMA,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_area_evaluasi' => ['required', 'max:255'],
            'judul' => ['required', 'max:255'],
            'deskripsi' => ['required']
        ]);
        $areaEvaluasi = AreaEvaluasi::find($id);

        AreaEvaluasi::where('id', $areaEvaluasi->id)->update([
            'nama_area_evaluasi' => $request->nama_area_evaluasi,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Area evaluasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
