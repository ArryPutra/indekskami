<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Evaluasi\JawabanIKategoriSE;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IKategoriSEController extends Controller
{
    public function index(HasilEvaluasi $hasilEvaluasi)
    {
        $daftarPertanyaan = PertanyaanIKategoriSE::where('apakah_tampil', true)->orderBy('nomor')->get();
        $daftarJawabanResponden = $hasilEvaluasi->jawabanIKategoriSE->keyBy('pertanyaan_id');

        $daftarPertanyaanDanJawaban = [];

        foreach ($daftarPertanyaan as $pertanyaan) {
            $jawaban = $daftarJawabanResponden[$pertanyaan->id] ?? null;

            $daftarPertanyaanDanJawaban[] = [
                'pertanyaan_id' => $pertanyaan->id,
                'nomor' => $pertanyaan->nomor,
                'catatan' => $pertanyaan->catatan,
                'pertanyaan' => $pertanyaan->pertanyaan,
                'status_pertama' => $pertanyaan->status_pertama,
                'status_kedua' => $pertanyaan->status_kedua,
                'status_ketiga' => $pertanyaan->status_ketiga,
                'skor_status_pertama' => $pertanyaan->skor_status_pertama,
                'skor_status_kedua' => $pertanyaan->skor_status_kedua,
                'skor_status_ketiga' => $pertanyaan->skor_status_ketiga,
                'status_jawaban' => $jawaban?->status_jawaban,
                'skor_jawaban' =>  $jawaban?->status_jawaban ? $pertanyaan[$jawaban->status_jawaban] : 0,
                'dokumen' => $jawaban?->dokumen,
                'keterangan' => $jawaban?->keterangan
            ];
        }

        $daftarAreaEvaluasi = AreaEvaluasi::all();

        return view('pages.evaluasi.i-kategori-se', [
            'title' => 'Evaluasi',
            'daftarPertanyaanDanJawaban' => $daftarPertanyaanDanJawaban,
            'totalSkorJawabanArray' => array_column($daftarPertanyaanDanJawaban, 'skor_jawaban'),
            'daftarAreaEvaluasiUtama' => $daftarAreaEvaluasi->whereNotIn('id', [1, 8]),
            'areaEvaluasi' => $daftarAreaEvaluasi->first(),
            'hasilEvaluasi' => $hasilEvaluasi,
            'daftarJudulTemaPertanyaan' => JudulTemaPertanyaan::where('area_evaluasi_id', 1)
                ->get()
        ]);
    }

    public function simpan(Request $request, HasilEvaluasi $hasilEvaluasi)
    {
        $user = Auth::user();
        $responden = $user->responden;

        $daftarJawaban = $request->except('_token');

        $daftarNomorJawabanTanpaDokumen = [];
        $daftarNomorJawabanTanpaStatus = [];
        $daftarNomorJawabanDokumenUkuranKebesaran = [];
        $daftarNomorJawabanDokumenTidakValid = [];

        foreach ($daftarJawaban as $nomor => $jawaban) {
            // Pengecekan status jawaban ada atau kosong
            $statusJawaban = $jawaban['status_jawaban'] ?? null;
            // Jika status jawaban ada dan tidak valid
            if ($statusJawaban && !in_array($statusJawaban, JawabanIKategoriSE::getStatusOptions())) {
                continue;
            }
            // Pengecekan dokumen pada pertanyaan
            $dokumen =
                // Jika ada unggah dokumen baru
                $jawaban['unggah_dokumen_baru']
                // Jika tidak ada dokumen baru maka ambil path dokumen lama
                ?? $jawaban['path_dokumen_lama'] ?? null;
            // Pengecekan keterangan
            $keterangan = $jawaban['keterangan'] ?? null;

            // Jika status jawaban atau dokumen kosong
            if (empty($statusJawaban) || empty($dokumen)) {
                // Jika dokumen kosong tetapi status jawaban ada
                if (empty($dokumen) && isset($statusJawaban)) {
                    $daftarNomorJawabanTanpaDokumen[] = '1.' . $nomor;
                }
                // Jika status jawaban kosong tetapi dokumen ada atau keterangan ada
                if (empty($statusJawaban) && (isset($dokumen) || isset($keterangan))) {
                    $daftarNomorJawabanTanpaStatus[] = '1.' . $nomor;
                }
                continue; // Lewati proses kode di bawah
            }

            $dokumenBaru = $jawaban['unggah_dokumen_baru'] ?? null;
            $pathDokumenSaatIni = $jawaban['path_dokumen_lama'] ?? null;

            // Jika ada unggah dokumen baru dan
            // jumlah karakter dokumen kurang dari 100 (untuk menambahkan  nama file ke table karena max: 255)
            if (isset($dokumenBaru) && strlen($dokumenBaru->getClientOriginalName()) <= 100) {
                // Pengecekan ukuran dokumen dalam MB
                $ukuranDokumenBaru_MB = number_format($dokumenBaru->getSize() / 1048576, 2);
                // Jika ukuran dokumen lebih besar dari 10 MB
                if ($ukuranDokumenBaru_MB > 10) {
                    $daftarNomorJawabanDokumenUkuranKebesaran[] = '1.' . $nomor;
                    continue;
                }
                // Jika tipe dokumen tidak sesuai
                $daftarEkstensiDokumenValid = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'rar', '7z'];
                $ekstensiDokumenBaru = $dokumenBaru->getClientOriginalExtension();
                if (!in_array($ekstensiDokumenBaru, $daftarEkstensiDokumenValid)) {
                    $daftarNomorJawabanDokumenTidakValid[] = '1.' . $nomor;
                    continue;
                }
                // Jika ada dokumen lama
                if (isset($jawaban['path_dokumen_lama'])) {
                    // Hapus dokumen lama
                    Storage::delete($jawaban['path_dokumen_lama']);
                }
                // Lalu tambahkan dokumen baru
                $pathDokumenSaatIni = $dokumenBaru->storeAs(
                    "Evaluasi/$responden->daerah/$user->username/Evaluasi " . $responden->hasilEvaluasi->count() . "/I Kategori SE",
                    $nomor . ' - ' . $dokumenBaru->getClientOriginalName()
                );
                // Simpan data dokumen ke database
                Files::create([
                    'user_id' => $user->id,
                    'path' => $pathDokumenSaatIni,
                    'tipe' => Files::EVALUASI,
                    'nama_file' => $dokumenBaru->getClientOriginalName()
                ]);
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

        $daftarInformasiPertanyaanKesalahan = array_filter([
            [
                'daftarNomor' => implode(', ', $daftarNomorJawabanTanpaDokumen),
                'pesan' => 'Mohon isi pertanyaan dengan dokumen.',
            ],
            [
                'daftarNomor' => implode(', ', $daftarNomorJawabanTanpaStatus),
                'pesan' => 'Mohon isi pertanyaan dengan status.'
            ],
            [
                'daftarNomor' => implode(', ', $daftarNomorJawabanDokumenUkuranKebesaran),
                'pesan' => 'Mohon isi pertanyaan dengan maksimal ukuran dokumen 10 MB.'
            ],
            [
                'daftarNomor' => implode(', ', $daftarNomorJawabanDokumenTidakValid),
                'pesan' => 'Mohon isi pertanyaan dengan dokumen yang valid.'
            ]
        ], fn($item) => !empty($item['daftarNomor']));

        return redirect()->route('responden.evaluasi.i-kategori-se', $hasilEvaluasi->id)
            ->with('daftarInformasiPertanyaanKesalahan', $daftarInformasiPertanyaanKesalahan);
    }
}
