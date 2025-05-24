<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class AreaEvaluasi extends Model
{
    protected $table = 'area_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const AREA_EVALUASI_I_KATEGORI_SE = 'I Kategori SE';
    const AREA_EVALUASI_II_TATA_KELOLA = 'II Tata Kelola';
    const AREA_EVALUASI_III_RISIKO = 'III Risiko';
    const AREA_EVALUASI_IV_KERANGKA_KERJA = 'IV Kerangka Kerja';
    const AREA_EVALUASI_V_PENGELOLAAN_ASET = 'V Pengelolaan Aset';
    const AREA_EVALUASI_VI_TEKNOLOGI = 'VI Teknologi';
    const AREA_EVALUASI_VII_PDP = 'VII PDP';
    const AREA_EVALUASI_VIII_SUPLEMEN = 'VIII Suplemen';

    const AREA_EVALUASI_I_KATEGORI_SE_ID = 1;
    const AREA_EVALUASI_II_TATA_KELOLA_ID = 2;
    const AREA_EVALUASI_III_RISIKO_ID = 3;
    const AREA_EVALUASI_IV_KERANGKA_KERJA_ID = 4;
    const AREA_EVALUASI_V_PENGELOLAAN_ASET_ID = 5;
    const AREA_EVALUASI_VI_TEKNOLOGI_ID = 6;
    const AREA_EVALUASI_VII_PDP_ID = 7;
    const AREA_EVALUASI_VIII_SUPLEMEN_ID = 8;

    public static function getAreaEvaluasiOptions()
    {
        return [
            self::AREA_EVALUASI_I_KATEGORI_SE,
            self::AREA_EVALUASI_II_TATA_KELOLA,
            self::AREA_EVALUASI_III_RISIKO,
            self::AREA_EVALUASI_IV_KERANGKA_KERJA,
            self::AREA_EVALUASI_V_PENGELOLAAN_ASET,
            self::AREA_EVALUASI_VI_TEKNOLOGI,
            self::AREA_EVALUASI_VII_PDP,
            self::AREA_EVALUASI_VIII_SUPLEMEN,
        ];
    }

    public function tipeEvaluasi()
    {
        return $this->belongsTo(TipeEvaluasi::class, 'tipe_evaluasi_id', 'id');
    }

    public function pertanyaanEvaluasi()
    {
        return $this->hasMany(PertanyaanEvaluasi::class, 'area_evaluasi_id', 'id');
    }

    public function skorEvaluasiUtamaTingkatKematangan()
    {
        return $this->hasOne(SkorEvaluasiUtamaTingkatKematangan::class, 'area_evaluasi_id', 'id');
    }

    public function nilaiEvaluasiUtama()
    {
        return $this->hasOne(NilaiEvaluasiUtama::class, 'area_evaluasi_id', 'id');
    }
}
