<?php

namespace App\Models\Responden;

use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Responden\NilaiEvaluasiUtama;
use App\Models\Responden\NilaiEvaluasiUtamaResponden;
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
    const KATEGORI_SE_RENDAH = 'Rendah';
    const KATEGORI_SE_TINGGI = 'Tinggi';
    const KATEGORI_SE_STRATEGIS = 'Strategis';
    public static function getKategoriSeOptions()
    {
        return [
            self::KATEGORI_SE_RENDAH,
            self::KATEGORI_SE_TINGGI,
            self::KATEGORI_SE_STRATEGIS
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
            $totalSkorKategoriSe < 16 => self::KATEGORI_SE_RENDAH,
            $totalSkorKategoriSe < 35 => self::KATEGORI_SE_TINGGI,
            default => self::KATEGORI_SE_STRATEGIS,
        };
    }

    public static function getSkorMaksimalIso()
    {
        $totalSkorEvaluasiUtama = PertanyaanEvaluasiUtama::whereHas('pertanyaanEvaluasi', function ($query) {
            $query->where('apakah_tampil', true);
        })->sum('skor_status_keempat');

        return $totalSkorEvaluasiUtama;
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

        if ($kategoriSe === self::KATEGORI_SE_RENDAH) {
            if ($tingkatKelengkapanIso <= 247) {
                return self::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK;
            } else if ($tingkatKelengkapanIso <= 443) {
                return self::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR;
            } else if ($tingkatKelengkapanIso <= 760) {
                return self::HASIL_EVALUASI_AKHIR_CUKUP_BAIK;
            } else if ($tingkatKelengkapanIso <= 918) {
                return self::HASIL_EVALUASI_AKHIR_BAIK;
            }
        } else if ($kategoriSe === self::KATEGORI_SE_TINGGI) {
            if ($tingkatKelengkapanIso <= 387) {
                return self::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK;
            } else if ($tingkatKelengkapanIso <= 646) {
                return self::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR;
            } else if ($tingkatKelengkapanIso <= 828) {
                return self::HASIL_EVALUASI_AKHIR_CUKUP_BAIK;
            } else if ($tingkatKelengkapanIso <= 918) {
                return self::HASIL_EVALUASI_AKHIR_BAIK;
            }
        } else if ($kategoriSe === self::KATEGORI_SE_STRATEGIS) {
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
        $maksimalSkorTingkatKelengkapanIso = self::getSkorMaksimalIso();

        return [
            'persentase'
            => round($tingkatKelengkapanIso / $maksimalSkorTingkatKelengkapanIso * 100),
            'skor'
            => $tingkatKelengkapanIso
        ];
    }

    public static function getPengamananKeterlibatanPihakKetiga($totalSkor)
    {
        return round($totalSkor / 27 * 100 / 3);
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
