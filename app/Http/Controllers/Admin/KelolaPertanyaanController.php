<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use Illuminate\Http\Request;

class KelolaPertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.kelola-pertanyaan.index', [
            'title' => 'Kelola Pertanyaan',
            'daftarAreaEvaluasi' => AreaEvaluasi::all()
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
    public function edit(string $id)
    {
        $areaEvaluasi = AreaEvaluasi::find($id);

        $daftarPertanyaan = $areaEvaluasi->pertanyaanIKategoriSe;

        return view('pages.admin.kelola-pertanyaan.form', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasi' => $areaEvaluasi,
            'daftarPertanyaan' => $daftarPertanyaan,
            'page_meta' => [
                'route' => route('kelola-pertanyaan.update', $areaEvaluasi->id),
                'method' => 'PUT'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
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

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function updatePertanyaan(Request $request, string $id)
    {
        $request->validate([
            'nomor' => ['required'],
            'pertanyaan' => ['required', 'max:255'],
            'status_a' => ['required', 'max:255'],
            'status_b' => ['required', 'max:255'],
            'status_c' => ['required', 'max:255'],
        ]);

        $pertanyaanId = $request['pertanyaan_id'];

        $pertanyaanBaru = $request;
        $pertanyaanLama = PertanyaanIKategoriSE::find($pertanyaanId);

        $pertanyaanLama->update([
            'nomor' => $pertanyaanBaru->nomor,
            'pertanyaan' => $pertanyaanBaru->pertanyaan,
            'status_a' => $pertanyaanBaru->status_a,
            'status_b' => $pertanyaanBaru->status_b,
            'status_c' => $pertanyaanBaru->status_c,
        ]);

        return redirect()->back()->with('success', 'Data pertanyaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
