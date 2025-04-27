<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Evaluasi\JudulTemaEvaluasiPertanyaan;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use Illuminate\Http\Request;

class EvaluasiUtamaController extends Controller
{
    public function index(HasilEvaluasi $hasilEvaluasi, AreaEvaluasi $areaEvaluasi)
    {
        $daftarPertanyaan = PertanyaanEvaluasiUtama::where('area_evaluasi_id', $areaEvaluasi->id)
            ->where('apakah_tampil', true)->orderBy('nomor')->get();
        $daftarJawabanResponden = $hasilEvaluasi->jawabanEvaluasiUtama->keyBy('pertanyaan_id');

        $daftarPertanyaanDanJawaban = [];

        foreach ($daftarPertanyaan as $pertanyaan) {
            $jawaban = $daftarJawabanResponden[$pertanyaan->id] ?? null;

            $daftarPertanyaanDanJawaban[] = [
                'pertanyaan_id' => $pertanyaan->id,
                'nomor' => $pertanyaan->nomor,
                'catatan' => $pertanyaan->catatan,
                'tingkat_kematangan' => $pertanyaan->tingkat_kematangan,
                'pertanyaan_tahap' => $pertanyaan->pertanyaan_tahap,
                'pertanyaan' => $pertanyaan->pertanyaan,
                'status_pertama' => $pertanyaan->status_pertama,
                'status_kedua' => $pertanyaan->status_kedua,
                'status_ketiga' => $pertanyaan->status_ketiga,
                'status_keempat' => $pertanyaan->status_keempat,
                'status_kelima' => $pertanyaan->status_kelima,
                'skor_status_pertama' => $pertanyaan->skor_status_pertama,
                'skor_status_kedua' => $pertanyaan->skor_status_kedua,
                'skor_status_ketiga' => $pertanyaan->skor_status_ketiga,
                'skor_status_keempat' => $pertanyaan->skor_status_keempat,
                'skor_status_kelima' => $pertanyaan?->skor_status_kelima,
                'status_jawaban' => $jawaban?->status_jawaban,
                'skor_jawaban' =>  $jawaban?->status_jawaban ? $pertanyaan[$jawaban->status_jawaban] : 0,
                'dokumen' => $jawaban?->dokumen,
                'keterangan' => $jawaban?->keterangan,
                'apakah_terkunci' => $pertanyaan->pertanyaan_tahap === 3
            ];
        }

        $daftarAreaEvaluasi = AreaEvaluasi::all();

        return view('pages.evaluasi.evaluasi-utama', [
            'title' => 'Evaluasi',
            'hasilEvaluasi' => $hasilEvaluasi,
            'daftarPertanyaanDanJawaban' => $daftarPertanyaanDanJawaban,
            'jumlahPertanyaanTahap1' => 0,
            'jumlahPertanyaanTahap2' => 0,
            'daftarAreaEvaluasiUtama' => $daftarAreaEvaluasi->whereNotIn('id', [1, 8]),
            'areaEvaluasi' => $areaEvaluasi,
            'daftarJudulTemaPertanyaan' => JudulTemaPertanyaan::where('area_evaluasi_id', $areaEvaluasi->id)->get(),
        ]);
    }

    public function simpan(Request $request, HasilEvaluasi $hasilEvaluasi, AreaEvaluasi $areaEvaluasi)
    {
        return $request;
    }
}
