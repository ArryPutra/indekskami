<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Evaluasi\SkorEvaluasiUtamaTingkatKematangan;
use Illuminate\Http\Request;

class KelolaTingkatKematangan extends Controller
{
    public function edit(string $areaEvaluasiId)
    {
        $areaEvaluasiId = session('areaEvaluasiId');
        $areaEvaluasi = AreaEvaluasi::findOrFail($areaEvaluasiId);

        $daftarPertanyaanEvaluasiUtamaId =
            PertanyaanEvaluasi::where('apakah_tampil', true)
            ->where('area_evaluasi_id', $areaEvaluasiId)->pluck('id');

        $daftarTingkatKematangan = PertanyaanEvaluasiUtama::whereIn('pertanyaan_evaluasi_id', $daftarPertanyaanEvaluasiUtamaId)
            ->distinct()
            ->pluck('tingkat_kematangan');

        $skorEvaluasiUtamaTingkatKematangan =
            $areaEvaluasi->skorEvaluasiUtamaTingkatKematangan;

        $daftarSkorTingkatKematangan = $daftarTingkatKematangan->map(function ($tingkatKematangan) use ($skorEvaluasiUtamaTingkatKematangan) {
            $key = strtolower($tingkatKematangan);

            return [
                'tingkat_kematangan' =>
                $tingkatKematangan,
                "skor_minimum_tingkat_kematangan_{$key}" =>
                $skorEvaluasiUtamaTingkatKematangan["skor_minimum_tingkat_kematangan_{$key}"],
                "skor_pencapaian_tingkat_kematangan_{$key}" =>
                $skorEvaluasiUtamaTingkatKematangan["skor_pencapaian_tingkat_kematangan_{$key}"],
            ];
        })->all();

        return view('pages.superadmin.kelola-pertanyaan.kelola-tingkat-kematangan.edit', [
            'title' => 'Tingkat Kematangan',
            'areaEvaluasiId' => $areaEvaluasi->id,
            'namaAreaEvaluasi' => $areaEvaluasi->nama_area_evaluasi,
            'namaTipeEvaluasi' => $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi,
            'skorEvaluasiUtamaTingkatKematanganId' => $skorEvaluasiUtamaTingkatKematangan->id,
            'daftarSkorTingkatKematangan' => $daftarSkorTingkatKematangan
        ]);
    }

    public function update(Request $request, string $skorEvaluasiUtamaTingkatKematanganId)
    {
        $validated = $request->validate([
            'skor_minimum_tingkat_kematangan_ii' => 'required|numeric',
            'skor_pencapaian_tingkat_kematangan_ii' => 'required|numeric',
            'skor_minimum_tingkat_kematangan_iii' => 'numeric|nullable',
            'skor_pencapaian_tingkat_kematangan_iii' => 'numeric|nullable',
            'skor_minimum_tingkat_kematangan_iv' => 'numeric|nullable',
            'skor_pencapaian_tingkat_kematangan_iv' => 'numeric|nullable',
            'skor_minimum_tingkat_kematangan_v' => 'numeric|nullable',
            'skor_pencapaian_tingkat_kematangan_v' => 'numeric|nullable',
        ]);

        $skorEvaluasiUtamaTingkatKematangan = SkorEvaluasiUtamaTingkatKematangan::find($skorEvaluasiUtamaTingkatKematanganId);

        $skorEvaluasiUtamaTingkatKematangan->update($validated);

        return redirect()->route('kelola-tingkat-kematangan.edit', $skorEvaluasiUtamaTingkatKematangan->area_evaluasi_id)->with('success', 'Data skor tingkat kematangan berhasil diperbarui!');
    }
}
