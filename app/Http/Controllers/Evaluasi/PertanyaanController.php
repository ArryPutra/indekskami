<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Evaluasi\JawabanEvaluasi;
use App\Models\Evaluasi\JawabanEvaluasiUtama;
use App\Models\Evaluasi\JawabanIKategoriSE;
use App\Models\Evaluasi\JawabanSuplemen;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use App\Models\Evaluasi\PertanyaanSuplemen;
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

        // # Daftar Pertanyaan # //
        $daftarPertanyaan = PertanyaanEvaluasi::query();
        switch ($tipeEvaluasi) {
            case TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK:
                $daftarPertanyaan = $daftarPertanyaan->with('pertanyaanKategoriSe');
                break;
            case TipeEvaluasi::EVALUASI_UTAMA:
                $daftarPertanyaan = $daftarPertanyaan->with('pertanyaanEvaluasiUtama');
                break;
            case TipeEvaluasi::EVALUASI_UTAMA:
                $daftarPertanyaan = $daftarPertanyaan->with('pertanyaanSuplemen');
                break;
        }
        $daftarPertanyaan = $daftarPertanyaan
            ->where('area_evaluasi_id', $areaEvaluasi->id)
            ->where('apakah_tampil', true)
            ->orderBy('nomor')
            ->get();
        // # Daftar Pertanyaan # //
        $daftarJawabanResponden = $hasilEvaluasi->jawabanEvaluasi
            ->whereIn('pertanyaan_evaluasi_id', $daftarPertanyaan->pluck('id'));

        $daftarPertanyaanDanJawaban = [];

        foreach ($daftarPertanyaan as $pertanyaan) {
            $jawaban = $daftarJawabanResponden
                ->where('pertanyaan_evaluasi_id', $pertanyaan->id)->first() ?? null;

            $pertanyaanDanJawaban = [
                'pertanyaan_id' => $pertanyaan->id,
                'nomor' => $pertanyaan->nomor,
                'catatan' => $pertanyaan->catatan,
                'pertanyaan' => $pertanyaan->pertanyaan,
            ];

            $pertanyaanEvaluasi = null;
            if ($tipeEvaluasi == TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK) {
                $pertanyaanEvaluasi = $pertanyaan->pertanyaanKategoriSe;
                $pertanyaanDanJawaban += [
                    'status_pertama' => $pertanyaanEvaluasi->status_pertama,
                    'status_kedua' => $pertanyaanEvaluasi->status_kedua,
                    'status_ketiga' => $pertanyaanEvaluasi->status_ketiga,
                    'skor_status_pertama' => $pertanyaanEvaluasi->skor_status_pertama,
                    'skor_status_kedua' => $pertanyaanEvaluasi->skor_status_kedua,
                    'skor_status_ketiga' => $pertanyaanEvaluasi->skor_status_ketiga,
                ];
            } else if ($tipeEvaluasi == TipeEvaluasi::EVALUASI_UTAMA) {
                $pertanyaanEvaluasi = $pertanyaan->pertanyaanEvaluasiUtama;
                $pertanyaanDanJawaban += [
                    'tingkat_kematangan' => $pertanyaanEvaluasi->tingkat_kematangan,
                    'pertanyaan_tahap' => $pertanyaanEvaluasi->pertanyaan_tahap,
                    'status_pertama' => $pertanyaanEvaluasi->status_pertama,
                    'status_kedua' => $pertanyaanEvaluasi->status_kedua,
                    'status_ketiga' => $pertanyaanEvaluasi->status_ketiga,
                    'status_keempat' => $pertanyaanEvaluasi->status_keempat,
                    'status_kelima' => $pertanyaanEvaluasi->status_kelima,
                    'skor_status_pertama' => $pertanyaanEvaluasi->skor_status_pertama,
                    'skor_status_kedua' => $pertanyaanEvaluasi->skor_status_kedua,
                    'skor_status_ketiga' => $pertanyaanEvaluasi->skor_status_ketiga,
                    'skor_status_keempat' => $pertanyaanEvaluasi->skor_status_keempat,
                    'skor_status_kelima' => $pertanyaanEvaluasi->skor_status_kelima,
                    'apakah_terkunci' => $pertanyaanEvaluasi->pertanyaan_tahap === 3,
                ];
            } else if ($tipeEvaluasi == TipeEvaluasi::SUPLEMEN) {
                $pertanyaanEvaluasi = $pertanyaan->pertanyaanSuplemen;
                $pertanyaanDanJawaban += [
                    'status_pertama' => $pertanyaanEvaluasi->status_pertama,
                    'status_kedua' => $pertanyaanEvaluasi->status_kedua,
                    'status_ketiga' => $pertanyaanEvaluasi->status_ketiga,
                    'status_keempat' => $pertanyaanEvaluasi->status_keempat,
                    'skor_status_pertama' => $pertanyaanEvaluasi->skor_status_pertama,
                    'skor_status_kedua' => $pertanyaanEvaluasi->skor_status_kedua,
                    'skor_status_ketiga' => $pertanyaanEvaluasi->skor_status_ketiga,
                    'skor_status_keempat' => $pertanyaanEvaluasi->skor_status_keempat,
                ];
            }

            $pertanyaanDanJawaban += [
                'status_jawaban' => $jawaban?->status_jawaban,
                'skor_jawaban' => $jawaban?->status_jawaban ?
                    ($pertanyaanEvaluasi->{'skor_' . $jawaban->status_jawaban} ?? 0) : 0,
                'dokumen' => $jawaban?->bukti_dokumen,
                'keterangan' => $jawaban?->keterangan,
            ];
            $daftarPertanyaanDanJawaban[] = $pertanyaanDanJawaban;
        }

        $daftarAreaEvaluasi = AreaEvaluasi::all();

        $dataScript = [
            'daftarPertanyaanDanJawaban' => collect($daftarPertanyaanDanJawaban)->map(function ($item) use ($tipeEvaluasi) {
                switch ($tipeEvaluasi) {
                    case TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK:
                        return [
                            'skor_jawaban' => $item['skor_jawaban'],
                            'apakah_pertanyaan_baru' => $item['status_jawaban'] === null ? true : false
                        ];
                        break;
                    case TipeEvaluasi::EVALUASI_UTAMA:
                        return [
                            'skor_jawaban' => $item['skor_jawaban'],
                            'pertanyaan_tahap' => $item['pertanyaan_tahap'],
                            'apakah_pertanyaan_baru' => $item['status_jawaban'] === null ? true : false
                        ];
                        break;
                    case TipeEvaluasi::SUPLEMEN:
                        return [
                            'skor_jawaban' => $item['skor_jawaban'],
                            'apakah_pertanyaan_baru' => $item['status_jawaban'] === null ? true : false
                        ];
                        break;
                }
            }),
            'daftarSkorJawabanArray' => array_column($daftarPertanyaanDanJawaban, 'skor_jawaban'),
            'totalPertanyaanDijawab' => collect($daftarPertanyaanDanJawaban)->where('status_jawaban', '!=', null)->count()
        ];

        switch ($tipeEvaluasi) {
            case TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK:
                // 
                break;
            case TipeEvaluasi::EVALUASI_UTAMA:
                $jumlahPertanyaanTahap1 = collect($daftarPertanyaanDanJawaban)->where('pertanyaan_tahap', 1);
                $jumlahPertanyaanTahap2 = collect($daftarPertanyaanDanJawaban)->where('pertanyaan_tahap', 2);

                $dataScript += [
                    'jumlahPertanyaanTahap1' => $jumlahPertanyaanTahap1->count(),
                    'jumlahPertanyaanTahap2' => $jumlahPertanyaanTahap2->count(),
                    'totalSkorTahapPenerapan1Dan2' => $jumlahPertanyaanTahap1->sum('skor_jawaban') + $jumlahPertanyaanTahap2->sum('skor_jawaban'),
                    'daftarSkorJawabanTahap1Dan2Array' => collect($daftarPertanyaanDanJawaban)->whereIn('pertanyaan_tahap', [1, 2])->pluck('skor_jawaban')
                ];
                break;
            case TipeEvaluasi::SUPLEMEN:
                // 
                break;
        }

        // return $daftarPertanyaanDanJawaban;

        return view('pages.evaluasi.pertanyaan', [
            'title' => 'Evaluasi',
            'daftarPertanyaanDanJawaban' => $daftarPertanyaanDanJawaban,
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
            $pertanyaanId = $jawaban['pertanyaan_id'] ?? null;
            $statusJawaban = $jawaban['status_jawaban'] ?? null;
            $keterangan = $jawaban['keterangan'] ?? null;
            $unggahDokumenBaru = $jawaban['unggah_dokumen_baru'] ?? null;
            $pathDokumenLama = $jawaban['path_dokumen_lama'] ?? null;
            $dokumen = $unggahDokumenBaru ?? $pathDokumenLama;

            $isSkorStatusPertama = $statusJawaban == 'status_pertama'
                && $tipeEvaluasi !== TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK;
            if ($isSkorStatusPertama) {
                if ($pathDokumenLama) {
                    Storage::delete($pathDokumenLama);
                }
                $dokumen = null;
            }

            // Jika validasi status jawaban tidak sesuai aturan
            if ($statusJawaban && !in_array($statusJawaban, JawabanEvaluasi::getStatusOptions())) {
                $errors['pesan_error'] = "Nomor $areaEvaluasiId.$nomor: opsi jawaban tidak valid.";
                continue;
            }

            // Validasi jika status jawaban kosong
            if (
                !$isSkorStatusPertama
                &&
                (empty($statusJawaban) || empty($dokumen))
            ) {
                // Jika dokumen kosong dan status jawaban ada
                if (empty($dokumen) && $statusJawaban) {
                    $errors['dokumen_kosong'][] = "$areaEvaluasiId.$nomor";
                }
                // Jika status jawaban kosong dan dokumen atau keterangan ada
                if (empty($statusJawaban) && ($dokumen || $keterangan)) {
                    $errors['status_kosong'][] = "$areaEvaluasiId.$nomor";
                }
                continue;
            }

            // Jika ada unggah dokumen
            if ($unggahDokumenBaru && !$isSkorStatusPertama) {
                $namaFile = $nomor . ' - ' . $unggahDokumenBaru->getClientOriginalName();
                $ukuranFileMb = $unggahDokumenBaru->getSize() / 1048576;
                $ekstensiFile = $unggahDokumenBaru->getClientOriginalExtension();

                // == Validasi File == //
                // Validasi ukuran file tidak boleh lebih dari 25 MB
                if ($ukuranFileMb > 25) {
                    $errors['dokumen_terlalu_besar'][] = "$areaEvaluasiId.$nomor";
                    continue; // Jangan lanjutkan kode di bawah
                }
                // Validasi ekstensi file sesuai format
                $ekstensiValid = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'rar', '7z'];
                if (!in_array($ekstensiFile, $ekstensiValid)) {
                    $errors['dokumen_tidak_valid'][] = "$areaEvaluasiId.$nomor";
                    continue;
                }
                // Validasi nama file dokumen tidak boleh lebih dari 100 karakter
                if (strlen($namaFile) > 100) {
                    $errors['pesan_error'] = "Nomor $areaEvaluasiId.$nomor: nama file dokumen terlalu panjang (maksimal 100 karakter).";
                    continue; // Jangan lanjutkan kode di bawah
                }
                // Validasi nama file
                $hurufTidakValid = ['&', '/'];
                if (strpbrk($namaFile, implode('', $hurufTidakValid))) {
                    $errors['pesan_error'] = "Nomor $areaEvaluasiId.$nomor: nama file dokumen tidak valid.";
                    continue;
                }

                // == Unggah File == //
                // Hapus dokumen lama
                if ($pathDokumenLama) {
                    Storage::delete($pathDokumenLama);
                }
                // Unggah file ke storage
                $pathDokumenSaatIni = $unggahDokumenBaru->storeAs(
                    "Evaluasi/{$responden->daerah}/{$user->username}/Evaluasi " . $responden->hasilEvaluasi->count() . "/$namaAreaEvaluasi",
                    $namaFile
                );
                // Memperbarui path dokumen dengan yang baru diunggah ke storage
                $dokumen = $pathDokumenSaatIni;
            }

            // Update atau tambahkan data jawaban evaluasi
            JawabanEvaluasi::updateOrCreate(
                [
                    'responden_id' => $responden->id,
                    'pertanyaan_evaluasi_id' => $pertanyaanId,
                    'hasil_evaluasi_id' => $hasilEvaluasi->id,
                ],
                [
                    'status_jawaban' => $statusJawaban,
                    'bukti_dokumen' => $dokumen,
                    'keterangan' => $keterangan
                ]
            );
        }

        // Validasi jawaban pertanyaan tahap 3
        // Jika tipe evaluasi adalah evaluasi utama
        if ($tipeEvaluasi === TipeEvaluasi::EVALUASI_UTAMA) {
            $daftarPertanyaanEvaluasi = PertanyaanEvaluasi::where('area_evaluasi_id', $areaEvaluasiId)
                ->with('pertanyaanEvaluasiUtama')->get();

            // Filter dan ambil ID pertanyaan tahap 1 dan 2 sekaligus
            $daftarPertanyaanIdTahap1Dan2 = $daftarPertanyaanEvaluasi->filter(
                fn($pertanyaan) =>
                in_array($pertanyaan->pertanyaanEvaluasiUtama->pertanyaan_tahap, [1, 2])
            )->pluck('id');

            // Mengambil semua jawaban sekaligus untuk tahap 1 dan 2
            $daftarJawabanTahap1Dan2 =
                $hasilEvaluasi->jawabanEvaluasi->whereIn('pertanyaan_evaluasi_id', $daftarPertanyaanIdTahap1Dan2);

            // Hitung total skor secara langsung dengan Collection
            $totalSkorTahap1Dan2 = $daftarJawabanTahap1Dan2->sum(
                fn($jawaban) =>
                $jawaban->pertanyaanEvaluasi->pertanyaanEvaluasiUtama['skor_' . $jawaban->status_jawaban]
            );
            // Hitung jumlah pertanyaan per tahap
            $jumlahPertanyaan = $daftarPertanyaanEvaluasi->groupBy(
                fn($pertanyaan) =>
                $pertanyaan->pertanyaanEvaluasiUtama->pertanyaan_tahap
            )->map->count();

            // Tentukan batas minimum skor
            $batasSkorMinUntukSkorTahapPenerapan3 = (2 * ($jumlahPertanyaan[1] ?? 0)) + (4 * ($jumlahPertanyaan[2] ?? 0));

            // Hapus jawaban tahap 3 jika skor tidak memenuhi batas minimum
            if ($totalSkorTahap1Dan2 < $batasSkorMinUntukSkorTahapPenerapan3) {
                $daftarPertanyaanIdTahap3 = $daftarPertanyaanEvaluasi->filter(
                    fn($pertanyaan) =>
                    $pertanyaan->pertanyaanEvaluasiUtama->pertanyaan_tahap === 3
                )->pluck('id');

                $hasilEvaluasi->jawabanEvaluasi->whereIn('pertanyaan_evaluasi_id', $daftarPertanyaanIdTahap3)
                    ->each(function ($item) {
                        Storage::delete($item->bukti_dokumen);
                        $item->delete();
                    });
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
