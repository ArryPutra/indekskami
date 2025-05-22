<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use App\Models\Evaluasi\TipeEvaluasi;
use Illuminate\Http\Request;

class KelolaJudulTemaPertanyaanController extends Controller
{

    public function index()
    {
        $areaEvaluasiId = session('areaEvaluasiId');
        $areaEvaluasi = AreaEvaluasi::findOrFail($areaEvaluasiId);

        return view('pages.superadmin.kelola-pertanyaan.kelola-judul-tema-pertanyaan.index', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasiId' => $areaEvaluasiId,
            'namaTipeEvaluasi' => $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi,
            'namaAreaEvaluasi' => $areaEvaluasi->nama_area_evaluasi,
            'daftarJudulTemaPertanyaan' => JudulTemaPertanyaan::where('area_evaluasi_id', $areaEvaluasiId)
                ->orderBy('letakkan_sebelum_nomor')->get(),
            'isEvaluasiUtama' => $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi === TipeEvaluasi::EVALUASI_UTAMA
        ]);
    }

    public function create()
    {
        return view('pages.superadmin.kelola-pertanyaan.kelola-judul-tema-pertanyaan.form', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasiId' => session('areaEvaluasiId'),
            'judulTemaPertanyaan' => new JudulTemaPertanyaan(),
            'pageMeta' => [
                'route' => route('kelola-judul-tema-pertanyaan.store'),
                'method' => 'POST'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $judulTemaPertanyaanBaru = $request->validate([
            'judul' => ['required', 'max:255'],
            'letakkan_sebelum_nomor' => ['required', 'numeric', 'min:1']
        ]);

        $areaEvaluasiId = session('areaEvaluasiId');

        JudulTemaPertanyaan::create([
            'area_evaluasi_id' => $areaEvaluasiId,
            'judul' => $judulTemaPertanyaanBaru['judul'],
            'letakkan_sebelum_nomor' => $judulTemaPertanyaanBaru['letakkan_sebelum_nomor']
        ]);

        return redirect()->route('kelola-judul-tema-pertanyaan.index')->with('success', 'Judul tema pertanyaan berhasil ditambahkan!');
    }

    public function edit(string $judulTemaPertanyaanId)
    {
        return view('pages.superadmin.kelola-pertanyaan.kelola-judul-tema-pertanyaan.form', [
            'title' => 'Kelola Pertanyaan',
            'judulTemaPertanyaan' => JudulTemaPertanyaan::find($judulTemaPertanyaanId),
            'pageMeta' => [
                'route' => route('kelola-judul-tema-pertanyaan.update', $judulTemaPertanyaanId),
                'method' => 'PUT'
            ]
        ]);
    }

    public function update(Request $request, string $judulTemaPertanyaanId)
    {
        $judulTemaPertanyaanBaru = $request->validate([
            'judul' => ['required', 'max:255'],
            'letakkan_sebelum_nomor' => ['required', 'numeric', 'min:1']
        ]);

        $judulTemaPertanyaan = JudulTemaPertanyaan::find($judulTemaPertanyaanId);
        $judulTemaPertanyaan->update([
            'judul' => $judulTemaPertanyaanBaru['judul'],
            'letakkan_sebelum_nomor' => $judulTemaPertanyaanBaru['letakkan_sebelum_nomor']
        ]);

        return redirect()->route('kelola-judul-tema-pertanyaan.index')->with('success', 'Judul tema pertanyaan berhasil diperbarui!');
    }

    public function destroy(string $judulTemaPertanyaanId)
    {
        $judulTemaPertanyaan = JudulTemaPertanyaan::find($judulTemaPertanyaanId);

        $judulTemaPertanyaan->delete();

        return redirect()->route('kelola-judul-tema-pertanyaan.index')->with('success', "Judul tema pertanyaan berhasil dihapus!");
    }
}
