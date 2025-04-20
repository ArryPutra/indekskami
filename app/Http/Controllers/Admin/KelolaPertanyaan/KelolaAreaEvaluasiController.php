<?php

namespace App\Http\Controllers\Admin\KelolaPertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use Illuminate\Http\Request;

class KelolaAreaEvaluasiController extends Controller
{

    public function edit(string $areaEvaluasiId)
    {
        // Store areaEvaluasiId ke session untuk keperluan redirect
        session(['areaEvaluasiId' => $areaEvaluasiId]);

        $areaEvaluasi = AreaEvaluasi::findOrFail($areaEvaluasiId);
        $daftarJudulTemaPertanyaan = JudulTemaPertanyaan::where('area_evaluasi_id', $areaEvaluasi->id)->get();

        return view('pages.admin.kelola-pertanyaan.kelola-area-evaluasi.edit', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasi' => $areaEvaluasi,
            'namaAreaEvaluasi' => $areaEvaluasi->nama_evaluasi,
            'daftarJudulTemaPertanyaan' => $daftarJudulTemaPertanyaan,
            'route' => route('kelola-area-evaluasi.update', $areaEvaluasi->id)
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_evaluasi' => ['required', 'max:255'],
            'judul' => ['required', 'max:255'],
            'deskripsi' => ['required']
        ]);
        $areaEvaluasi = AreaEvaluasi::find($id);

        AreaEvaluasi::where('id', $areaEvaluasi->id)->update([
            'nama_evaluasi' => $request->nama_evaluasi,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Area evaluasi berhasil diperbarui!');
    }
}
