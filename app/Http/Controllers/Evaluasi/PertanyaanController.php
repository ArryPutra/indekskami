<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Evaluasi\JawabanEvaluasiUtama;
use App\Models\Evaluasi\JawabanIKategoriSE;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use App\Models\Evaluasi\TipeEvaluasi;
use App\Models\Files;
use App\Models\KepemilikanDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PertanyaanController extends Controller
{
    public function index(AreaEvaluasi $areaEvaluasi, HasilEvaluasi $hasilEvaluasi)
    {
        $tipeEvaluasi = $areaEvaluasi->tipeEvaluasi->tipe_evaluasi;
        // Menyesuaikan daftar pertanyaan berdasarkan tipe evaluasi
        $daftarPertanyaan = match ($tipeEvaluasi) {
            TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK => PertanyaanIKategoriSE::where('apakah_tampil', true)->orderBy('nomor')->get(),
            TipeEvaluasi::EVALUASI_UTAMA => PertanyaanEvaluasiUtama::where('area_evaluasi_id', $areaEvaluasi->id)
                ->where('apakah_tampil', true)->orderBy('nomor')->get(),
            default => collect()
        };

        $daftarJawabanResponden = match ($tipeEvaluasi) {
            TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK => $hasilEvaluasi->jawabanIKategoriSE
                ->keyBy('pertanyaan_id'),
            TipeEvaluasi::EVALUASI_UTAMA => $hasilEvaluasi->jawabanEvaluasiUtama
                ->where('area_evaluasi_id', $areaEvaluasi->id)->keyBy('pertanyaan_id'),
            default => collect()
        };

        $daftarPertanyaanDanJawaban = [];

        foreach ($daftarPertanyaan as $pertanyaan) {
            $jawaban = $daftarJawabanResponden[$pertanyaan->id] ?? null;

            if ($tipeEvaluasi == TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK) {
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
                    'skor_jawaban' => $jawaban?->status_jawaban ? ($pertanyaan->{$jawaban->status_jawaban} ?? 0) : 0,
                    'dokumen' => $jawaban?->dokumen,
                    'keterangan' => $jawaban?->keterangan,
                ];
            } else if ($tipeEvaluasi == TipeEvaluasi::EVALUASI_UTAMA) {
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
        }

        $daftarAreaEvaluasi = AreaEvaluasi::all();

        $dataScript = [];
        switch ($tipeEvaluasi) {
            case TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK:
                break;
            case TipeEvaluasi::EVALUASI_UTAMA:
                $jumlahPertanyaanTahap1 = collect($daftarPertanyaanDanJawaban)->where('pertanyaan_tahap', 1);
                $jumlahPertanyaanTahap2 = collect($daftarPertanyaanDanJawaban)->where('pertanyaan_tahap', 2);

                $dataScript = [
                    'jumlahPertanyaanTahap1' => $jumlahPertanyaanTahap1->count(),
                    'jumlahPertanyaanTahap2' => $jumlahPertanyaanTahap2->count(),
                    'totalSkorTahapPenerapan1Dan2' => $jumlahPertanyaanTahap1->sum('skor_jawaban') + $jumlahPertanyaanTahap2->sum('skor_jawaban'),
                    'daftarSkorJawabanTahap1Dan2Array' => collect($daftarPertanyaanDanJawaban)->whereIn('pertanyaan_tahap', [1, 2])->pluck('skor_jawaban')
                ];
                break;
        }

        return view('pages.evaluasi.pertanyaan', [
            'title' => 'Evaluasi',
            'daftarPertanyaanDanJawaban' => $daftarPertanyaanDanJawaban,
            'daftarSkorJawabanArray' => array_column($daftarPertanyaanDanJawaban, 'skor_jawaban'),
            'daftarAreaEvaluasiUtama' => $daftarAreaEvaluasi,
            'areaEvaluasi' => $areaEvaluasi,
            'hasilEvaluasi' => $hasilEvaluasi,
            'daftarJudulTemaPertanyaan' => JudulTemaPertanyaan::where('area_evaluasi_id', $areaEvaluasi->id)
                ->get(),
            'tipeEvaluasi' => $areaEvaluasi->tipeEvaluasi->tipe_evaluasi,
            'dataScript' => $dataScript,
        ]);
    }

    public function simpan(Request $request, AreaEvaluasi $areaEvaluasi, HasilEvaluasi $hasilEvaluasi)
    {
        $user = Auth::user();
        $responden = $user->responden;
        $areaEvaluasiId = $areaEvaluasi->id;
        $tipeEvaluasi = $areaEvaluasi->tipeEvaluasi->tipe_evaluasi;
        $namaAreaEvaluasi = $areaEvaluasi->nama_evaluasi;
        $daftarJawaban = $request->except('_token');

        // Kumpulan daftar error
        $errors = [
            'pesan_error' => null,
            'dokumen_kosong' => [],
            'status_kosong' => [],
            'dokumen_terlalu_besar' => [],
            'dokumen_tidak_valid' => [],
        ];

        foreach ($daftarJawaban as $nomor => $jawaban) {
            $statusJawaban = $jawaban['status_jawaban'] ?? null;
            $keterangan = $jawaban['keterangan'] ?? null;
            $dokumenBaru = $jawaban['unggah_dokumen_baru'] ?? null;
            $pathDokumenLama = $jawaban['path_dokumen_lama'] ?? null;
            $dokumen = $dokumenBaru ?? $pathDokumenLama;

            $jawabanModel = match ($tipeEvaluasi) {
                TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK => new JawabanIKategoriSE(),
                TipeEvaluasi::EVALUASI_UTAMA => new JawabanEvaluasiUtama(),
                default => null
            };

            if ($jawabanModel === null) {
                $errors['pesan_error'] = "Nomor $areaEvaluasiId.$nomor: jawaban model tidak ditemukan.";
                continue;
            }

            // Validasi status jawaban
            if ($statusJawaban && !in_array($statusJawaban, $jawabanModel::getStatusOptions())) {
                $errors['pesan_error'] = "Nomor $areaEvaluasiId.$nomor: opsi jawaban tidak valid.";
                continue;
            }

            $isSkorStatusPertama = $statusJawaban === 'skor_status_pertama' && $tipeEvaluasi !== TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK;

            if ($isSkorStatusPertama) {
                if ($pathDokumenLama) {
                    Storage::delete($pathDokumenLama);

                    JawabanEvaluasiUtama::getKepemilikanDokumen(
                        $responden->id,
                        $hasilEvaluasi->id,
                        $areaEvaluasiId,
                        $jawaban['pertanyaan_id']
                    )->delete();

                    JawabanEvaluasiUtama::where('responden_id', $responden->id)
                        ->where('area_evaluasi_id', $areaEvaluasiId)
                        ->where('pertanyaan_id', $jawaban['pertanyaan_id'])
                        ->where('hasil_evaluasi_id', $hasilEvaluasi->id)
                        ->first()?->update(['dokumen' => null]);
                }
                $dokumen = null;
            }

            // Validasi jawaban kosong
            if (!$isSkorStatusPertama && (empty($statusJawaban) || empty($dokumen))) {
                if (empty($dokumen) && $statusJawaban) {
                    $errors['dokumen_kosong'][] = "$areaEvaluasiId.$nomor";
                }
                if (empty($statusJawaban) && ($dokumen || $keterangan)) {
                    $errors['status_kosong'][] = "$areaEvaluasiId.$nomor";
                }
                continue;
            }

            // Proses dokumen baru jika ada
            if ($dokumenBaru && !$isSkorStatusPertama) {
                $namaFile = $nomor . ' - ' . $dokumenBaru->getClientOriginalName();

                if (strlen($namaFile) > 100) {
                    // Nama file terlalu panjang, lanjut tanpa simpan
                    $errors['pesan_error'] = "Nomor $areaEvaluasiId.$nomor: nama file dokumen terlalu panjang (maksimal 100 karakter).";
                    continue;
                }

                $ukuranMB = $dokumenBaru->getSize() / 1048576;

                if ($ukuranMB > 10) {
                    $errors['dokumen_terlalu_besar'][] = "$areaEvaluasiId.$nomor";
                    continue;
                }

                $hurufTidakValid = ['&', '/'];
                // $hurufTidakValid = ['&', '/', '?', '=', '#', '%', ' ', '"', '<', '>', '{', '}', '\\', '^', '`', '|', '~', '[', ']', ';', ':'];
                if (strpbrk($namaFile, implode('', $hurufTidakValid))) {
                    $errors['pesan_error'] = "Nomor $areaEvaluasiId.$nomor: nama file dokumen tidak valid.";
                    continue;
                }

                $ekstensiValid = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'rar', '7z'];
                $ekstensi = $dokumenBaru->getClientOriginalExtension();

                if (!in_array($ekstensi, $ekstensiValid)) {
                    $errors['dokumen_tidak_valid'][] = "$areaEvaluasiId.$nomor";
                    continue;
                }

                if ($pathDokumenLama) {
                    Storage::delete($pathDokumenLama);
                }

                $pathDokumenSaatIni = $dokumenBaru->storeAs(
                    "Evaluasi/{$responden->daerah}/{$user->username}/Evaluasi " . $responden->hasilEvaluasi->count() . "/$namaAreaEvaluasi",
                    $namaFile
                );

                $dokumen = $pathDokumenSaatIni;

                // Simpan ke tabel dokumen
                KepemilikanDokumen::updateOrCreate(
                    [
                        'responden_id' => $responden->id,
                        'hasil_evaluasi_id' => $hasilEvaluasi->id,
                        'area_evaluasi_id' => $areaEvaluasiId,
                        'pertanyaan_id' => $jawaban['pertanyaan_id'],
                    ],
                    [
                        'path' => $pathDokumenSaatIni,
                    ]
                );
            }

            // Simpan atau update jawaban
            $jawabanModel::updateOrCreate(
                [
                    'area_evaluasi_id' => $areaEvaluasiId,
                    'responden_id' => $responden->id,
                    'pertanyaan_id' => $jawaban['pertanyaan_id'],
                    'hasil_evaluasi_id' => $hasilEvaluasi->id,
                ],
                [
                    'status_jawaban' => $statusJawaban,
                    'dokumen' => $dokumen,
                    'keterangan' => $keterangan
                ]
            );
        }

        // Validasi jawaban pertanyaan tahap 3
        // Jika tipe evaluasi adalah evaluasi utama
        if ($tipeEvaluasi === TipeEvaluasi::EVALUASI_UTAMA) {
            // Mencari pertanyaan ID tahap 1 dan 2
            $daftarPertanyaanIdTahap1Dan2 = PertanyaanEvaluasiUtama::where('area_evaluasi_id', $areaEvaluasi->id)->whereIn('pertanyaan_tahap', [1, 2])->pluck('id');
            $daftarJawabanTahap1Dan2 = $hasilEvaluasi->jawabanEvaluasiUtama->whereIn('pertanyaan_id', $daftarPertanyaanIdTahap1Dan2);

            $totalSkorTahap1Dan2 = 0;
            foreach ($daftarJawabanTahap1Dan2 as $jawabanTahap1Dan2) {
                $totalSkorTahap1Dan2 += $jawabanTahap1Dan2->pertanyaan[$jawabanTahap1Dan2->status_jawaban];
            }

            $jumlahPertanyaanTahap1 = PertanyaanEvaluasiUtama::where('area_evaluasi_id', $areaEvaluasi->id)->where('pertanyaan_tahap', 1)->count();
            $jumlahPertanyaanTahap2 = PertanyaanEvaluasiUtama::where('area_evaluasi_id', $areaEvaluasi->id)->where('pertanyaan_tahap', 2)->count();
            $batasSkorMinUntukSkorTahapPenerapan3 = 2 * $jumlahPertanyaanTahap1 + 4 * $jumlahPertanyaanTahap2;

            if ($totalSkorTahap1Dan2 < $batasSkorMinUntukSkorTahapPenerapan3) {
                $daftarPertanyaanIdTahap3 = PertanyaanEvaluasiUtama::where('area_evaluasi_id', $areaEvaluasi->id)->where('pertanyaan_tahap', 3)->pluck('id');
                $hasilEvaluasi->jawabanEvaluasiUtama->whereIn('pertanyaan_id', $daftarPertanyaanIdTahap3)
                    ->each(fn($item) => $item->delete());
            }
        }

        // Format error untuk redirect
        $daftarInformasiPertanyaanKesalahan = array_filter([
            ['daftarNomor' => implode(', ', $errors['dokumen_kosong']), 'pesan' => 'Mohon isi pertanyaan dengan dokumen.'],
            ['daftarNomor' => implode(', ', $errors['status_kosong']), 'pesan' => 'Mohon isi pertanyaan dengan status.'],
            ['daftarNomor' => implode(', ', $errors['dokumen_terlalu_besar']), 'pesan' => 'Mohon isi pertanyaan dengan maksimal ukuran dokumen 10 MB.'],
            ['daftarNomor' => implode(', ', $errors['dokumen_tidak_valid']), 'pesan' => 'Mohon isi pertanyaan dengan dokumen yang valid.']
        ], fn($item) => !empty($item['daftarNomor']));

        return redirect()->route('responden.evaluasi.pertanyaan', [$areaEvaluasiId, $hasilEvaluasi->id])
            ->with('daftarInformasiPertanyaanKesalahan', $daftarInformasiPertanyaanKesalahan)
            ->with('pesanError', $errors['pesan_error']);
    }
}
