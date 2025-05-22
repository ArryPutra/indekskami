<?php

namespace App\Models\Responden;

use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\NilaiEvaluasiUtama;
use App\Models\Evaluasi\NilaiEvaluasiUtamaResponden;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Evaluasi\SkorEvaluasiUtamaTingkatKematangan;
use App\Models\Responden\JawabanEvaluasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NilaiEvaluasi extends Model
{
    protected $table = 'nilai_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function nilaiEvaluasiUtamaResponden()
    {
        return $this->hasMany(NilaiEvaluasiUtamaResponden::class);
    }

    // Skor Kategori SE
    const SKOR_KATEGORI_SE_RENDAH = 'Rendah';
    const SKOR_KATEGORI_SE_TINGGI = 'Tinggi';
    const SKOR_KATEGORI_SE_STRATEGIS = 'Strategis';
    public static function getSkorKategoriSeOptions()
    {
        return [
            self::SKOR_KATEGORI_SE_RENDAH,
            self::SKOR_KATEGORI_SE_TINGGI,
            self::SKOR_KATEGORI_SE_STRATEGIS
        ];
    }

    // Hasil Evaluasi Akhir
    const HASIL_EVALUASI_AKHIR_TIDAK_LAYAK = 'Tidak Layak';
    const HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR = 'Pemenuhan Kerangka Kerja Dasar';
    const HASIL_EVALUASI_AKHIR_CUKUP_BAIK = 'Cukup Baik';
    const HASIL_EVALUASI_AKHIR_BAIK = 'Baik';
    public static function getHasilEvaluasiAkhirOptions()
    {
        return [
            self::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK,
            self::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR,
            self::HASIL_EVALUASI_AKHIR_CUKUP_BAIK,
            self::HASIL_EVALUASI_AKHIR_BAIK
        ];
    }

    public static function getKategoriSe(int $totalSkorKategoriSe)
    {
        return match (true) {
            $totalSkorKategoriSe < 16 => self::SKOR_KATEGORI_SE_RENDAH,
            $totalSkorKategoriSe < 35 => self::SKOR_KATEGORI_SE_TINGGI,
            default => self::SKOR_KATEGORI_SE_STRATEGIS,
        };
    }

    public static function getHasilEvaluasiAkhir(
        string $kategoriSe,
        int $tingkatKelengkapanIso,
        $nilaiEvaluasiUtama,
        $nilaiEvaluasiUtamaResponden,
    ) {
        $ambangBatasValid = false;

        $daftarEvaluasiUtamaId = $nilaiEvaluasiUtama
            ->whereIn('nama_nilai_evaluasi_utama', NilaiEvaluasiUtama::getNilaiEvaluasiUtamaOptions())
            ->pluck('id', 'nama_nilai_evaluasi_utama');

        $daftarTotalSkorEvaluasi = collect(NilaiEvaluasiUtama::getNilaiEvaluasiUtamaOptions())->mapWithKeys(function ($option) use ($nilaiEvaluasiUtamaResponden, $daftarEvaluasiUtamaId) {
            return [
                "{$option}" => $nilaiEvaluasiUtamaResponden
                    ->where('nilai_evaluasi_utama_id', $daftarEvaluasiUtamaId[$option] ?? null)
                    ->value('total_skor')
            ];
        })->all();

        $daftarPertanyaanTahap1 = [];
        foreach (AreaEvaluasi::getAreaEvaluasiOptions() as $areaEvaluasi) {
            $areaEvaluasiId = AreaEvaluasi::where('nama_area_evaluasi', $areaEvaluasi)->value('id');
            $daftarPertanyaanId = PertanyaanEvaluasi::where('area_evaluasi_id', $areaEvaluasiId)->pluck('id');

            $jumlah = PertanyaanEvaluasiUtama::whereIn('pertanyaan_evaluasi_id', $daftarPertanyaanId)
                ->where('pertanyaan_tahap', 1)
                ->count();

            // Gunakan nama array yang lebih deskriptif jika mau, misal tanpa prefix AREA_EVALUASI_
            $key = str_replace(['AREA_EVALUASI_', '_'], ['', ''], $areaEvaluasi);
            $daftarPertanyaanTahap1[$key] = $jumlah;
        }

        // Mapping nama area ke faktor pengali
        $faktorPengali = [
            'II Tata Kelola' => 2,
            'III Risiko' => 2,
            'IV Kerangka Kerja' => 2,
            'V Pengelolaan Aset' => 1,
            'VI Teknologi' => 1,
        ];
        $ambangBatasValidEvaluasi = [];

        // Loop melalui area dan hitung ambang batasnya
        foreach ($faktorPengali as $area => $faktor) {
            $key = 'ambangBatasValid' . str_replace(' ', '', $area); // Misal: 'ambangBatasValidIITataKelola'
            $ambangBatasValidEvaluasi[$key] = $daftarPertanyaanTahap1[$area] * $faktor;
        }

        if (
            $daftarTotalSkorEvaluasi['Tata Kelola'] >= $ambangBatasValidEvaluasi['ambangBatasValidIITataKelola']
            && $daftarTotalSkorEvaluasi['Pengelolaan Risiko'] >= $ambangBatasValidEvaluasi['ambangBatasValidIIIRisiko']
            && $daftarTotalSkorEvaluasi['Kerangka Kerja Keamanan Informasi'] >= $ambangBatasValidEvaluasi['ambangBatasValidIVKerangkaKerja']
            && $daftarTotalSkorEvaluasi['Pengelolaan Aset'] >= $ambangBatasValidEvaluasi['ambangBatasValidVPengelolaanAset']
            && $daftarTotalSkorEvaluasi['Teknologi dan Keamanan Informasi'] >= $ambangBatasValidEvaluasi['ambangBatasValidVITeknologi']
        ) {
            $ambangBatasValid = true;
        }

        if (!$ambangBatasValid) {
            return self::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK;
        }

        if ($kategoriSe === self::SKOR_KATEGORI_SE_RENDAH) {
            if ($tingkatKelengkapanIso <= 247) {
                return self::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK;
            } else if ($tingkatKelengkapanIso <= 443) {
                return self::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR;
            } else if ($tingkatKelengkapanIso <= 760) {
                return self::HASIL_EVALUASI_AKHIR_CUKUP_BAIK;
            } else if ($tingkatKelengkapanIso <= 918) {
                return self::HASIL_EVALUASI_AKHIR_BAIK;
            }
        } else if ($kategoriSe === self::SKOR_KATEGORI_SE_TINGGI) {
            if ($tingkatKelengkapanIso <= 387) {
                return self::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK;
            } else if ($tingkatKelengkapanIso <= 646) {
                return self::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR;
            } else if ($tingkatKelengkapanIso <= 828) {
                return self::HASIL_EVALUASI_AKHIR_CUKUP_BAIK;
            } else if ($tingkatKelengkapanIso <= 918) {
                return self::HASIL_EVALUASI_AKHIR_BAIK;
            }
        } else if ($kategoriSe === self::SKOR_KATEGORI_SE_STRATEGIS) {
            if ($tingkatKelengkapanIso <= 472) {
                return self::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK;
            } else if ($tingkatKelengkapanIso <= 760) {
                return self::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR;
            } else if ($tingkatKelengkapanIso <= 864) {
                return self::HASIL_EVALUASI_AKHIR_CUKUP_BAIK;
            } else if ($tingkatKelengkapanIso <= 918) {
                return self::HASIL_EVALUASI_AKHIR_BAIK;
            }
        }
    }

    public static function getTingkatKelengkapanIso(int $tingkatKelengkapanIso)
    {
        $totalSkorEvaluasiUtama = PertanyaanEvaluasiUtama::whereHas('pertanyaanEvaluasi', function ($query) {
            $query->where('apakah_tampil', true);
        })->sum('skor_status_keempat');

        $maksimalSkorTingkatKelengkapanIso = $totalSkorEvaluasiUtama;

        return [
            'persentase'
            => round($tingkatKelengkapanIso / $maksimalSkorTingkatKelengkapanIso * 100),
            'skor'
            => $tingkatKelengkapanIso
        ];
    }

    public static function getStatusPenilaianTahapPenerapan3(
        $daftarPertanyaanDanJawaban
    ) {
        $daftarJawabanTahap1 = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 1);

        $totalSkorTahapPenerapan1 = $daftarJawabanTahap1->sum('skor_jawaban');
        $totalJawabanTahap1TidakDiterapkan = $daftarJawabanTahap1->where('skor_jawaban', 0)->count();
        $totalJawabanTahap1DalamPerencanaan = $daftarJawabanTahap1->where('skor_jawaban', 1)->count();
        $totalJawabanTahap1DiterapkanSebagian = $daftarJawabanTahap1->where('skor_jawaban', 2)->count();
        $totalJawabanTahap1DiterapkanSecaraMenyeluruh = $daftarJawabanTahap1->where('skor_jawaban', 3)->count();

        $skorValiditasTahapPenerapan3 = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 1)->count() * 3;

        $statusValiditasTahapPenerapn3 = 'NO';
        if (
            $totalJawabanTahap1DalamPerencanaan === 0
            && $totalSkorTahapPenerapan1 >= ($skorValiditasTahapPenerapan3 - 2)
            && $totalJawabanTahap1DiterapkanSebagian <= 2
        ) {
            $statusValiditasTahapPenerapn3 = 'OK';
        }

        $jumlahPertanyaanTahap1 = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 1)->count();
        $jumlahPertanyaanTahap2 = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 2)->count();
        $batasSkorMinUntukSkorTahapPenerapan3 = (2 * $jumlahPertanyaanTahap1) + (4 * $jumlahPertanyaanTahap2);

        $totalSkorTahapPenerapan1Dan2 = $daftarPertanyaanDanJawaban->whereIn('pertanyaan_tahap', [1, 2])->sum('skor_jawaban');
        if (
            $totalSkorTahapPenerapan1Dan2 >= $batasSkorMinUntukSkorTahapPenerapan3
            && $statusValiditasTahapPenerapn3 == 'OK'
        ) {
            return true;
        } else {
            return false;
        }
    }

    public static function getStatusTingkatKematangan(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
        $daftarSkorTingkatKematangan
    ) {
        $statusTingkatKematanganII = self::getStatusTingkatKematanganII(
            $daftarPertanyaanDanJawaban,
            $skorEvaluasiUtamaTingkatKematangan,
        );
        $statusTingkatKematanganIII = self::getStatusTingkatKematanganIII(
            $daftarPertanyaanDanJawaban,
            $skorEvaluasiUtamaTingkatKematangan,
        );
        $statusTingkatKematanganIV = self::getStatusTingkatKematanganIV(
            $daftarPertanyaanDanJawaban,
            $skorEvaluasiUtamaTingkatKematangan
        );
        $statusTingkatKematanganV = self::getStatusTingkatKematanganV(
            $daftarPertanyaanDanJawaban,
            $skorEvaluasiUtamaTingkatKematangan
        );

        if (
            $statusTingkatKematanganV !== 'No'
            && collect($daftarSkorTingkatKematangan)->contains('tingkatKematangan', 'V')
        ) {
            return $statusTingkatKematanganV;
        } else if (
            $statusTingkatKematanganIV !== 'No'
            && collect($daftarSkorTingkatKematangan)->contains('tingkatKematangan', 'IV')
        ) {
            return $statusTingkatKematanganIV;
        } else if (
            $statusTingkatKematanganIII !== 'No'
            && collect($daftarSkorTingkatKematangan)->contains('tingkatKematangan', 'III')
        ) {
            return $statusTingkatKematanganIII;
        } else {
            return $statusTingkatKematanganII;
        }
    }

    private static function getStatusTingkatKematanganII(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
    ) {
        $totalSkorJawabanTingkatKematanganII = $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_jawaban');
        $skorMinimumTingkatKematanganII = $skorEvaluasiUtamaTingkatKematangan['skor_minimum_tingkat_kematangan_ii'];
        $skorPencapaianTingkatKematanganII = $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_ii'];

        if ($totalSkorJawabanTingkatKematanganII >= $skorPencapaianTingkatKematanganII) {
            return 'II';
        } else if ($totalSkorJawabanTingkatKematanganII >= $skorMinimumTingkatKematanganII) {
            return 'I+';
        } else {
            return 'I';
        }
    }

    private static function getStatusTingkatKematanganIII(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
    ) {
        $totalSkorJawabanTingkatKematanganIII = $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'III')->sum('skor_jawaban');
        $validitasTingkatKematanganIII =
            $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "II")->sum('skor_jawaban')
            >= $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_status_keempat') * (80 / 100)
            &&
            self::getStatusPenilaianTahapPenerapan3($daftarPertanyaanDanJawaban);
        $skorMinimumTingkatKematanganIII = $skorEvaluasiUtamaTingkatKematangan['skor_minimum_tingkat_kematangan_iii'];
        $skorPencapaianTingkatKematanganIII = $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_iii'];

        if ($validitasTingkatKematanganIII) {
            if ($totalSkorJawabanTingkatKematanganIII >= $skorPencapaianTingkatKematanganIII) {
                return 'III';
            } else if ($totalSkorJawabanTingkatKematanganIII >= $skorMinimumTingkatKematanganIII) {
                return 'II+';
            } else {
                return 'II';
            }
        } else {
            return 'No';
        }
    }

    private static function getStatusTingkatKematanganIV(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
    ) {

        $skorValiditasTingkatKematanganIV = match ($skorEvaluasiUtamaTingkatKematangan->areaEvaluasi->nama_area_evaluasi) {
            AreaEvaluasi::AREA_EVALUASI_II_TATA_KELOLA => 16,
            AreaEvaluasi::AREA_EVALUASI_III_RISIKO => 10,
            AreaEvaluasi::AREA_EVALUASI_IV_KERANGKA_KERJA => 92,
            AreaEvaluasi::AREA_EVALUASI_V_PENGELOLAAN_ASET => 61,
            AreaEvaluasi::AREA_EVALUASI_VI_TEKNOLOGI => 64,
            default => 0
        };

        $totalSkorJawabanTingkatKematanganIV = $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'IV')->sum('skor_jawaban');
        $validitasTingkatKematanganIV =
            ($daftarPertanyaanDanJawaban->where('tingkat_kematangan', "II")->sum('skor_jawaban')
                >= $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_status_keempat') * (80 / 100)
                &&
                self::getStatusPenilaianTahapPenerapan3($daftarPertanyaanDanJawaban))
            &&
            $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "III")->sum('skor_jawaban')
            >= $skorValiditasTingkatKematanganIV;
        $skorMinimumTingkatKematanganIV = $skorEvaluasiUtamaTingkatKematangan['skor_minimum_tingkat_kematangan_iv'];
        $skorPencapaianTingkatKematanganIV = $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_iv'];

        if ($validitasTingkatKematanganIV) {
            if (
                ($daftarPertanyaanDanJawaban->where('tingkat_kematangan', "II")->sum('skor_jawaban')
                    >= $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_status_keempat'))
                &&
                (
                    $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "III")->sum('skor_jawaban')
                    >=
                    $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'III')->sum('skor_status_keempat')
                )
                &&
                (
                    $totalSkorJawabanTingkatKematanganIV
                    >=
                    $skorPencapaianTingkatKematanganIV
                )

            ) {
                return 'IV';
            } else if (
                $totalSkorJawabanTingkatKematanganIV
                >=
                $skorMinimumTingkatKematanganIV
            ) {
                return 'III+';
            } else {
                return 'III';
            }
        } else {
            return 'No';
        }
    }

    private static function getStatusTingkatKematanganV(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
    ) {
        $skorValiditasTingkatKematanganIV = match ($skorEvaluasiUtamaTingkatKematangan->areaEvaluasi->nama_area_evaluasi) {
            AreaEvaluasi::AREA_EVALUASI_II_TATA_KELOLA => 16,
            AreaEvaluasi::AREA_EVALUASI_III_RISIKO => 10,
            AreaEvaluasi::AREA_EVALUASI_IV_KERANGKA_KERJA => 92,
            AreaEvaluasi::AREA_EVALUASI_V_PENGELOLAAN_ASET => 61,
            AreaEvaluasi::AREA_EVALUASI_VI_TEKNOLOGI => 64,
            default => 0
        };

        $totalSkorJawabanTingkatKematanganV = $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'V')->sum('skor_jawaban');
        $validitasTingkatKematanganV =
            (($daftarPertanyaanDanJawaban->where('tingkat_kematangan', "II")->sum('skor_jawaban')
                >= $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_status_keempat') * (80 / 100)
                &&
                self::getStatusPenilaianTahapPenerapan3($daftarPertanyaanDanJawaban))
                &&
                $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "III")->sum('skor_jawaban')
                >= $skorValiditasTingkatKematanganIV)
            &&
            $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "IV")->sum('skor_jawaban')
            >= $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_iv'];
        $skorMinimumTingkatKematanganV = $skorEvaluasiUtamaTingkatKematangan['skor_minimum_tingkat_kematangan_v'];
        $skorPencapaianTingkatKematanganV = $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_v'];

        if ($validitasTingkatKematanganV) {
            if ($totalSkorJawabanTingkatKematanganV >= $skorPencapaianTingkatKematanganV) {
                return 'V';
            } else if ($totalSkorJawabanTingkatKematanganV >= $skorMinimumTingkatKematanganV) {
                return 'IV+';
            } else {
                return 'V';
            }
        } else {
            return 'No';
        }
    }

    public static function getSkorTingkatKematangan(string $statusTingkatKematangan)
    {
        return match ($statusTingkatKematangan) {
            'I' => 1,
            'I+' => 1.5,
            'II' => 2,
            'II+' => 2.5,
            'III' => 3,
            'III+' => 3.5,
            'IV' => 4,
            'IV+' => 4.5,
            'V' => 5,
        };
    }
}
