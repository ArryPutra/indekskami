<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\JawabanEvaluasi;
use App\Models\Evaluasi\JudulTemaPertanyaan;
use App\Models\Evaluasi\NilaiEvaluasiUtama;
use App\Models\Evaluasi\NilaiEvaluasiUtamaResponden;
use App\Models\Evaluasi\PeraturanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\TipeEvaluasi;
use App\Models\Peran;
use App\Models\Responden\NilaiEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PertanyaanController extends Controller
{

    public function index(AreaEvaluasi $areaEvaluasi, HasilEvaluasi $hasilEvaluasi)
    {
        $namaTipeEvaluasi = $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi;

        $daftarPertanyaanDanJawaban = $this->getDaftarPertanyaanDanJawaban(
            $namaTipeEvaluasi,
            $areaEvaluasi->id,
            $hasilEvaluasi
        );

        $dataScript = [
            'daftarPertanyaanDanJawaban' => collect($daftarPertanyaanDanJawaban)->map(function ($item) use ($namaTipeEvaluasi) {
                switch ($namaTipeEvaluasi) {
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

        switch ($namaTipeEvaluasi) {
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

        $isResponden = Auth::user()->peran_id === Peran::PERAN_RESPONDEN_ID;

        $apakahEvaluasiDapatDikerjakan = false;
        $statusHasilEvaluasiId = $hasilEvaluasi->statusHasilEvaluasi->id;
        // Jika evaluasi sedang dikerjakan oleh responden
        if (
            $statusHasilEvaluasiId === StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID
            && $isResponden
        ) {
            $apakahEvaluasiDapatDikerjakan = true;
        } // Jika evaluasi diperiksa oleh verifikator maka buat dapat evaluasi bisa dikerjakan
        else if (
            $statusHasilEvaluasiId === StatusHasilEvaluasi::STATUS_DITINJAU_ID
            && !$isResponden
        ) {
            $apakahEvaluasiDapatDikerjakan = true;
        }

        return view('pages.evaluasi.pertanyaan', [
            'title' => 'Evaluasi',
            'daftarPertanyaanDanJawaban' => $daftarPertanyaanDanJawaban,
            'daftarAreaEvaluasiUtama' => AreaEvaluasi::all(),
            'areaEvaluasi' => $areaEvaluasi,
            'hasilEvaluasi' => $hasilEvaluasi,
            'statusHasilEvaluasiSaatIni' => $hasilEvaluasi->statusHasilEvaluasi->nama_status_hasil_evaluasi,
            'daftarJudulTemaPertanyaan' => JudulTemaPertanyaan::where('area_evaluasi_id', $areaEvaluasi->id)->get(),
            'namaTipeEvaluasi' => $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi,
            'dataScript' => $dataScript,
            'isResponden' => $isResponden,
            'apakahEvaluasiDapatDikerjakan' => $apakahEvaluasiDapatDikerjakan,
            'routeSimpanJawaban' =>
            route(
                $isResponden ?
                    'responden.evaluasi.pertanyaan.simpan-jawaban'
                    : 'verifikator.evaluasi.pertanyaan.simpan-jawaban',
                [$areaEvaluasi->id, $hasilEvaluasi->id]
            )
        ]);
    }

    public function simpanJawaban(Request $request, AreaEvaluasi $areaEvaluasi, HasilEvaluasi $hasilEvaluasi)
    {
        $isResponden = Auth::user()->peran_id === Peran::PERAN_RESPONDEN_ID;

        $responden = $hasilEvaluasi->responden;
        $areaEvaluasiId = $areaEvaluasi->id;
        $namaTipeEvaluasi = $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi;
        $namaAreaEvaluasi = $areaEvaluasi->nama_area_evaluasi;
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

            $dokumen = 'dokumen.pdf';
            JawabanEvaluasi::updateOrCreate(
                [
                    'responden_id' => $responden->id,
                    'pertanyaan_evaluasi_id' => $pertanyaanId,
                    'hasil_evaluasi_id' => $hasilEvaluasi->id,
                ],
                [
                    'status_jawaban' => 'status_keempat',
                    'bukti_dokumen' => $dokumen,
                    'keterangan' => $keterangan
                ]
            );

            $isSkorStatusPertama = $statusJawaban == 'status_pertama'
                && $namaTipeEvaluasi !== TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK;
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

            // Validasi jika status jawaban atau dokumen kosong
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
                $peraturanEvaluasi = PeraturanEvaluasi::first();
                // Validasi ukuran file tidak boleh lebih dari 10 MB
                $maksimalUkuranDokumen = $peraturanEvaluasi->maksimal_ukuran_dokumen;
                if ($ukuranFileMb > $maksimalUkuranDokumen) {
                    $errors['dokumen_terlalu_besar'][] = "$areaEvaluasiId.$nomor";
                    continue; // Jangan lanjutkan kode di bawah
                }
                // Validasi ekstensi file sesuai format
                $ekstensiValid = json_decode($peraturanEvaluasi->daftar_ekstensi_dokumen_valid);
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
                    "Evaluasi/{$responden->daerah}/{$responden->user->username}/Evaluasi " . $responden->hasilEvaluasi->count() . "/$namaAreaEvaluasi",
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

        $daftarPertanyaanDanJawaban = collect($this->getDaftarPertanyaanDanJawaban(
            $namaTipeEvaluasi,
            $areaEvaluasiId,
            $hasilEvaluasi
        ));

        // Validasi jawaban pertanyaan tahap 3
        // Jika tipe evaluasi adalah evaluasi utama
        if ($namaTipeEvaluasi === TipeEvaluasi::EVALUASI_UTAMA) {
            // Jika status penilaian tahap 3 tida valid
            if (!NilaiEvaluasiUtamaResponden::getStatusPenilaianTahapPenerapan3($daftarPertanyaanDanJawaban, $areaEvaluasiId)) {
                $daftarPertanyaanTahap3Id = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 3)->pluck('pertanyaan_id');

                // Menghapus semua jawaban pertanyaan tahap 3
                $hasilEvaluasi->jawabanEvaluasi->whereIn('pertanyaan_evaluasi_id', $daftarPertanyaanTahap3Id)
                    ->each(function ($jawaban) {
                        if ($jawaban->bukti_dokumen) {
                            Storage::delete($jawaban->bukti_dokumen);
                        }
                        $jawaban->delete();
                    });
            }
        }

        // Update nilai evaluasi ke database berdasarkan tipe evaluasi.
        $nilaiEvaluasi = $hasilEvaluasi->nilaiEvaluasi()->with('nilaiEvaluasiUtamaResponden')->first();
        $totalSkorEvaluasi = $daftarPertanyaanDanJawaban->sum('skor_jawaban');

        switch ($namaTipeEvaluasi) {
            case TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK:
                // Update nilai evaluasi ke database
                $nilaiEvaluasi->update([
                    'skor_kategori_se' => $totalSkorEvaluasi,
                    'kategori_se' => NilaiEvaluasi::getKategoriSe($totalSkorEvaluasi),
                ]);
                break;
            case TipeEvaluasi::EVALUASI_UTAMA:
                $nilaiEvaluasiUtamaId =
                    $areaEvaluasi->nilaiEvaluasiUtama->id;
                $nilaiEvaluasiUtamaResponden = $nilaiEvaluasi->nilaiEvaluasiUtamaResponden
                    ->where('nilai_evaluasi_utama_id', $nilaiEvaluasiUtamaId)->first();

                $daftarTingkatKematanganTersedia = $daftarPertanyaanDanJawaban
                    ->unique('tingkat_kematangan')
                    ->pluck('tingkat_kematangan');

                $skorEvaluasiUtamaTingkatKematangan =
                    $areaEvaluasi->skorEvaluasiUtamaTingkatKematangan;

                $daftarSkorTingkatKematangan =
                    $daftarTingkatKematanganTersedia->map(function ($tingkatKematangan)
                    use ($daftarPertanyaanDanJawaban, $skorEvaluasiUtamaTingkatKematangan) {
                        $key = strtolower($tingkatKematangan);

                        return [
                            'tingkatKematangan' => $tingkatKematangan,
                            'totalSkor' => $daftarPertanyaanDanJawaban
                                ->where('tingkat_kematangan', $tingkatKematangan)
                                ->sum('skor_jawaban'),
                            'skorMinimum' => $skorEvaluasiUtamaTingkatKematangan["skor_minimum_tingkat_kematangan_{$key}"] ?? 0,
                            'skorPencapaian' => $skorEvaluasiUtamaTingkatKematangan["skor_pencapaian_tingkat_kematangan_{$key}"] ?? 0,
                        ];
                    })->all();

                DB::transaction(function () use (
                    $nilaiEvaluasiUtamaResponden,
                    $totalSkorEvaluasi,
                    $daftarSkorTingkatKematangan,
                    $nilaiEvaluasi,
                    $skorEvaluasiUtamaTingkatKematangan,
                    $daftarPertanyaanDanJawaban,
                    $areaEvaluasiId
                ) {
                    // # Update nilai evaluasi utama responden ke database
                    $nilaiEvaluasiUtamaResponden->update([
                        'total_skor' =>
                        $totalSkorEvaluasi,
                        'status_tingkat_kematangan'
                        => NilaiEvaluasiUtamaResponden::getStatusTingkatKematangan(
                            $daftarPertanyaanDanJawaban,
                            $skorEvaluasiUtamaTingkatKematangan,
                            $daftarSkorTingkatKematangan,
                            $areaEvaluasiId,
                        )
                    ]);

                    // # Update nilai evaluasi ke database
                    $nilaiEvaluasi->update([
                        'tingkat_kelengkapan_iso'
                        => $nilaiEvaluasi->nilaiEvaluasiUtamaResponden->sum('total_skor'),
                        'hasil_evaluasi_akhir'
                        => NilaiEvaluasi::getHasilEvaluasiAkhir(
                            $nilaiEvaluasi->kategori_se,
                            $nilaiEvaluasi->nilaiEvaluasiUtamaResponden->sum('total_skor'),
                            NilaiEvaluasiUtama::all(),
                            $nilaiEvaluasi->nilaiEvaluasiUtamaResponden
                        )
                    ]);
                });

                break;
            case TipeEvaluasi::SUPLEMEN:
                // # Update nilai evaluasi ke database
                $nilaiEvaluasi->update([
                    'pengamanan_keterlibatan_pihak_ketiga'
                    =>  NilaiEvaluasi::getPengamananKeterlibatanPihakKetiga($totalSkorEvaluasi)
                ]);
                break;
        }
        // Format error untuk redirect
        $daftarInformasiPertanyaanKesalahan = array_filter([
            ['daftarNomor' => implode(', ', $errors['dokumen_kosong']), 'pesan' => 'Mohon isi pertanyaan dengan dokumen.'],
            ['daftarNomor' => implode(', ', $errors['status_kosong']), 'pesan' => 'Mohon isi pertanyaan dengan status.'],
            ['daftarNomor' => implode(', ', $errors['dokumen_terlalu_besar']), 'pesan' => "Mohon isi pertanyaan dengan maksimal ukuran dokumen " . ($maksimalUkuranDokumen ?? '') . " MB."],
            ['daftarNomor' => implode(', ', $errors['dokumen_tidak_valid']), 'pesan' => "Mohon isi pertanyaan dengan dokumen yang valid (" . implode(', ', $ekstensiValid ?? []) . ').']
        ], fn($item) => !empty($item['daftarNomor']));

        return redirect()->route(
            $isResponden ? 'responden.evaluasi.pertanyaan' : 'verifikator.evaluasi.pertanyaan',
            [$areaEvaluasiId, $hasilEvaluasi->id]
        )
            ->with('daftarInformasiPertanyaanKesalahan', $daftarInformasiPertanyaanKesalahan)
            ->with('pesanError', $errors['pesan_error']);
    }

    private function getDaftarPertanyaanDanJawaban(
        string $namaTipeEvaluasi,
        int $areaEvaluasiId,
        HasilEvaluasi $hasilEvaluasi
    ) {
        // # Daftar Pertanyaan Query # //
        $daftarPertanyaanQuery = PertanyaanEvaluasi::query();

        // Menyesuaikan pertanyaan evaluasi berdasarkan tipe evaluasi sehingga
        // mendapatkan relasi tabel pertanyaan sesuai dengan tipe evaluasi
        switch ($namaTipeEvaluasi) {
            case TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK:
                $daftarPertanyaanQuery = $daftarPertanyaanQuery->with('pertanyaanKategoriSe');
                break;
            case TipeEvaluasi::EVALUASI_UTAMA:
                $daftarPertanyaanQuery = $daftarPertanyaanQuery->with('pertanyaanEvaluasiUtama');
                break;
            case TipeEvaluasi::SUPLEMEN:
                $daftarPertanyaanQuery = $daftarPertanyaanQuery->with('pertanyaanSuplemen');
                break;
        }

        // Mendapatkan data pertanyaan evaluasi dalam bentuk array
        $daftarPertanyaanQuery = $daftarPertanyaanQuery
            ->where('area_evaluasi_id', $areaEvaluasiId)
            ->where('apakah_tampil', true)
            ->orderBy('nomor')
            ->get();

        // Mendapatkan daftar jawaban responden (menyesuaikan berdasarkan pertanyaan evaluasi yang telah diquery) # //
        $daftarJawabanResponden = $hasilEvaluasi->jawabanEvaluasi
            ->whereIn('pertanyaan_evaluasi_id', $daftarPertanyaanQuery->pluck('id'));

        $daftarPertanyaanDanJawaban = [];

        foreach ($daftarPertanyaanQuery as $pertanyaan) {
            // Mencari jawaban sesuai pertanyaanId
            $jawaban = $daftarJawabanResponden
                ->firstWhere('pertanyaan_evaluasi_id', $pertanyaan->id);

            $pertanyaanDanJawaban = [
                'pertanyaan_id' => $pertanyaan->id,
                'nomor' => $pertanyaan->nomor,
                'catatan' => $pertanyaan->catatan,
                'pertanyaan' => $pertanyaan->pertanyaan,
            ];

            $pertanyaanEvaluasi = null;
            if ($namaTipeEvaluasi == TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK) {
                $pertanyaanEvaluasi = $pertanyaan->pertanyaanKategoriSe;
                $pertanyaanDanJawaban += [
                    'status_pertama' => $pertanyaanEvaluasi->status_pertama,
                    'status_kedua' => $pertanyaanEvaluasi->status_kedua,
                    'status_ketiga' => $pertanyaanEvaluasi->status_ketiga,
                    'skor_status_pertama' => $pertanyaanEvaluasi->skor_status_pertama,
                    'skor_status_kedua' => $pertanyaanEvaluasi->skor_status_kedua,
                    'skor_status_ketiga' => $pertanyaanEvaluasi->skor_status_ketiga,
                ];
            } else if ($namaTipeEvaluasi == TipeEvaluasi::EVALUASI_UTAMA) {
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
            } else if ($namaTipeEvaluasi == TipeEvaluasi::SUPLEMEN) {
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

        if (
            NilaiEvaluasiUtamaResponden::getStatusPenilaianTahapPenerapan3(
                collect($daftarPertanyaanDanJawaban),
                $areaEvaluasiId
            )
            && $namaTipeEvaluasi == TipeEvaluasi::EVALUASI_UTAMA
        ) {
            $daftarPertanyaanDanJawaban = collect($daftarPertanyaanDanJawaban)->map(function ($item) {
                if (array_key_exists('apakah_terkunci', $item)) {
                    $item['apakah_terkunci'] = false;
                }
                return $item;
            })->toArray();
        }

        return $daftarPertanyaanDanJawaban;
    }
}
