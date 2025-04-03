<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Evaluasi\JawabanIKategoriSE;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IKategoriSEController extends Controller
{
    public function index(HasilEvaluasi $hasilEvaluasi)
    {
        $user = Auth::user();

        $daftarPertanyaan = PertanyaanIKategoriSE::all();
        $daftarJawabanResponden = $hasilEvaluasi->jawabanIKategoriSE->keyBy('pertanyaan_id');

        $daftarPertanyaanDanJawaban = [];

        foreach ($daftarPertanyaan as $pertanyaan) {
            $jawaban = $daftarJawabanResponden[$pertanyaan->id] ?? null;

            $daftarPertanyaanDanJawaban[] = [
                'pertanyaan_id' => $pertanyaan->id,
                'nomor' => $pertanyaan->nomor,
                'pertanyaan' => $pertanyaan->pertanyaan,
                'status_a' => $pertanyaan->status_a,
                'status_b' => $pertanyaan->status_b,
                'status_c' => $pertanyaan->status_c,
                'status_jawaban' => $jawaban?->status_jawaban,
                'skor_jawaban' =>  $jawaban?->status_jawaban ? $pertanyaan['skor_' . $jawaban->status_jawaban] : 0,
                'dokumen' => $jawaban?->dokumen,
                'keterangan' => $jawaban?->keterangan
            ];
        }

        $daftarAreaEvaluasi = AreaEvaluasi::all();

        return view('pages.responden.evaluasi.i-kategori-se', [
            'title' => 'Evaluasi',
            'daftarPertanyaanDanJawaban' => $daftarPertanyaanDanJawaban,
            'totalSkorJawabanArray' => array_column($daftarPertanyaanDanJawaban, 'skor_jawaban'),
            'daftarAreaEvaluasi' => $daftarAreaEvaluasi,
            'areaEvaluasi' => $daftarAreaEvaluasi->first(),
            'identitasRespondenId' => $hasilEvaluasi->identitasResponden->id,
        ]);
    }

    public function simpan(Request $request)
    {
        $user = Auth::user();
        $responden = $user->responden;

        $hasilEvaluasi = $responden->hasilEvaluasi()->latest()->first();

        $daftarJawaban = $request->except('_token');

        $daftarJawabanTanpaDokumen = [];
        $daftarJawabanTanpaStatus = [];
        $daftarJawabanDokumenUkuranKebesaran = [];
        $daftarJawabanDokumenTidakValid = [];
        foreach ($daftarJawaban as $nomor => $jawaban) {
            $statusJawaban = $jawaban['status_jawaban'] ?? null;
            // Pengecekan dokumen pada pertanyaan
            $dokumen =
                // Jika ada unggah dokumen baru
                $jawaban['unggah_dokumen_baru']
                // Jika tidak ada dokumen baru maka ambil path dokumen lama
                ?? $jawaban['path_dokumen_lama'] ?? null;
            $keterangan = $jawaban['keterangan'] ?? null;

            // Jika status jawaban dan dokumen kosong
            if (empty($statusJawaban) || empty($dokumen)) {
                // Jika dokumen kosong tetapi status jawaban ada
                if (empty($dokumen) && isset($statusJawaban)) {
                    $daftarJawabanTanpaDokumen[] = '1.' . $nomor;
                }
                // Jika status jawaban kosong tetapi dokumen ada atau keterangan ada
                if (empty($statusJawaban) && (isset($dokumen) || isset($keterangan))) {
                    $daftarJawabanTanpaStatus[] = '1.' . $nomor;
                }
                continue; // Lewati proses kode di bawah
            }

            $dokumenBaru = $jawaban['unggah_dokumen_baru'] ?? null;
            $pathDokumenSaatIni = $jawaban['path_dokumen_lama'] ?? null;

            // Jika ada unggah dokumen baru
            if (isset($dokumenBaru)) {
                // Pengecekan ukuran dokumen dalam MB
                $ukuranDokumenBaru_MB = number_format($dokumenBaru->getSize() / 1048576, 2);
                // Jika ukuran dokumen lebih besar dari 10 MB
                if ($ukuranDokumenBaru_MB > 10) {
                    $daftarJawabanDokumenUkuranKebesaran[] = '1.' . $nomor;
                    continue;
                }
                // Jika tipe dokumen tidak sesuai
                $daftarEkstensiDokumenValid = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'rar', '7z'];
                $ekstensiDokumenBaru = $dokumenBaru->getClientOriginalExtension();
                if (!in_array($ekstensiDokumenBaru, $daftarEkstensiDokumenValid)) {
                    $daftarJawabanDokumenTidakValid[] = '1.' . $nomor;
                    continue;
                }
                // Jika ada dokumen lama
                if (isset($jawaban['path_dokumen_lama'])) {
                    // Hapus dokumen lama
                    Storage::delete($jawaban['path_dokumen_lama']);
                }
                // Lalu tambahkan dokumen baru
                $pathDokumenSaatIni = $dokumenBaru->storeAs(
                    "evaluasi/$user->username/evaluasi-ke-" . $responden->hasilEvaluasi->count() . "/i-kategori-se",
                    $nomor . '-' . $dokumenBaru->getClientOriginalName()
                );
            }

            JawabanIKategoriSE::updateOrCreate(
                [
                    'responden_id' => $responden->id,
                    'pertanyaan_id' => $jawaban['pertanyaan_id'],
                    'hasil_evaluasi_id' => $hasilEvaluasi->id,
                ],
                [
                    'status_jawaban' => $statusJawaban,
                    'dokumen' => $pathDokumenSaatIni,
                    'keterangan' => $jawaban['keterangan']
                ]
            );
        }

        return redirect()->route('responden.evaluasi.i-kategori-se')
            ->with('daftarJawabanTanpaDokumen', implode(', ', $daftarJawabanTanpaDokumen))
            ->with('daftarJawabanTanpaStatus', implode(', ', $daftarJawabanTanpaStatus))
            ->with('daftarJawabanDokumenUkuranKebesaran', implode(', ', $daftarJawabanDokumenUkuranKebesaran))
            ->with('daftarJawabanDokumenTidakValid', implode(', ', $daftarJawabanDokumenTidakValid));
    }
}
