<?php

namespace App\Models\Responden;

use Illuminate\Database\Eloquent\Model;

class NilaiEvaluasi extends Model
{
    protected $table = 'nilai_evaluasi';

    protected $fillable = [
        'responden_id',
        'skor_kategori_se',
        'kategori_se',
        'hasil_evaluasi_akhir',
        'tingkat_kelengkapan_iso',
        'tata_kelola',
        'pengelolaan_risiko',
        'kerangka_kerja_keamanan_informasi',
        'teknologi_dan_keamanan_informasi',
        'perlindungan_data_pribadi',
        'pengamanan_keterlibatan_pihak_ketiga',
        't_kematangan_tata_kelola',
        't_kematangan_pengelolaan_risiko',
        't_kematangan_kerangka_kerja_keamanan_informasi',
        't_kematangan_pengelolaan_aset',
        't_kematangan_teknologi_dan_keamanan_informasi',
        't_kematangan_perlindungan_data_pribadi'
    ];

    // Skor Kategori SE
    const SKOR_KATEGORI_SE_RENDAH = 'Rendah';
    const SKOR_KATEGORI_SE_TINGGI = 'Tinggi';
    const SKOR_KATEGORI_SE_STRATEGIS = 'Strategis';
    public static function getSkorKategoriSE()
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
    public static function getHasilEvaluasiAkhir()
    {
        return [
            self::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK,
            self::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR,
            self::HASIL_EVALUASI_AKHIR_CUKUP_BAIK,
            self::HASIL_EVALUASI_AKHIR_BAIK
        ];
    }

    // Tingkat Kematangan
    const T_KEMATANGAN_I = 'I';
    const T_KEMATANGAN_II = 'II';
    const T_KEMATANGAN_III = 'III';
    const T_KEMATANGAN_IV = 'IV';
    const T_KEMATANGAN_V = 'V';
    public static function getTingkatKematangan()
    {
        return [
            self::T_KEMATANGAN_I,
            self::T_KEMATANGAN_II,
            self::T_KEMATANGAN_III,
            self::T_KEMATANGAN_IV,
            self::T_KEMATANGAN_V
        ];
    }
}
