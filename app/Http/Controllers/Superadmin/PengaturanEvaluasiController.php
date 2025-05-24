<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\PeraturanEvaluasi;
use Illuminate\Http\Request;

class PengaturanEvaluasiController extends Controller
{
    public function index()
    {
        $peraturanEvaluasi = PeraturanEvaluasi::first();

        return view('pages.superadmin.kelola-pertanyaan.pengaturan', [
            'title' => 'Pengaturan Evaluasi',
            'maksimalUkuranDokumen' => $peraturanEvaluasi->maksimal_ukuran_dokumen,
            'daftarEkstensiDokumenValid' => $peraturanEvaluasi->daftar_ekstensi_dokumen_valid,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'maksimal_ukuran_dokumen' => ['required', 'numeric', 'min:1'],
            'daftar_ekstensi_dokumen_valid' => ['required', 'json'],
        ]);

        $peraturanEvaluasi = PeraturanEvaluasi::first();

        $peraturanEvaluasi->update([
            'maksimal_ukuran_dokumen' => $request->maksimal_ukuran_dokumen,
            'daftar_ekstensi_dokumen_valid' => $request->daftar_ekstensi_dokumen_valid,
        ]);

        return redirect()->route('pengaturan-evaluasi.index')
            ->with('success', 'Peraturan Evaluasi berhasil diperbarui');
    }
}
