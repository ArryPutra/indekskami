<?php

namespace App\Models\Responden;

use Illuminate\Database\Eloquent\Model;

class NilaiEvaluasiUtama extends Model
{
    protected $table = 'nilai_evaluasi_utama';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const NILAI_EVALUASI_UTAMA_TATA_KELOLA = 'Tata Kelola';
    const NILAI_EVALUASI_UTAMA_PENGELOLAAN_RISIKO = 'Pengelolaan Risiko';
    const NILAI_EVALUASI_UTAMA_KERANGKA_KERJA_KEAMANAN_INFORMASI = 'Kerangka Kerja Keamanan Informasi';
    const NILAI_EVALUASI_UTAMA_PENGELOLAAN_ASET = 'Pengelolaan Aset';
    const NILAI_EVALUASI_UTAMA_TEKNOLOGI_DAN_KEAMANAN_INFORMASI = 'Teknologi dan Keamanan Informasi';
    const NILAI_EVALUASI_UTAMA_PERLINDUNGAN_DATA_PRIBADI = 'Perlindungan Data Pribadi';

    public static function getNilaiEvaluasiUtamaOptions()
    {
        return [
            self::NILAI_EVALUASI_UTAMA_TATA_KELOLA,
            self::NILAI_EVALUASI_UTAMA_PENGELOLAAN_RISIKO,
            self::NILAI_EVALUASI_UTAMA_KERANGKA_KERJA_KEAMANAN_INFORMASI,
            self::NILAI_EVALUASI_UTAMA_PENGELOLAAN_ASET,
            self::NILAI_EVALUASI_UTAMA_TEKNOLOGI_DAN_KEAMANAN_INFORMASI,
            self::NILAI_EVALUASI_UTAMA_PERLINDUNGAN_DATA_PRIBADI,
        ];
    }

    public function nilaiEvaluasiUtamaResponden()
    {
        return $this->hasMany(NilaiEvaluasiUtamaResponden::class, 'nilai_evaluasi_utama_id', 'id');
    }
}
