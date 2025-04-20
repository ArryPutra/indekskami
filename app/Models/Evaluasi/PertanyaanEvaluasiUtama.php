<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class PertanyaanEvaluasiUtama extends Model
{
    protected $table = 'pertanyaan_evaluasi_utama';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const TINGKAT_KEMATANGAN_II = 'II';
    const TINGKAT_KEMATANGAN_III = 'III';
    const TINGKAT_KEMATANGAN_IV = 'IV';
    const TINGKAT_KEMATANGAN_V = 'V';

    public static function getTingkatKematanganOptions()
    {
        return [
            self::TINGKAT_KEMATANGAN_II,
            self::TINGKAT_KEMATANGAN_III,
            self::TINGKAT_KEMATANGAN_IV,
            self::TINGKAT_KEMATANGAN_V
        ];
    }

    function getJawabanResponden($areaEvaluasiId, $respondenId, $hasilEvaluasiId, $pertanyaanId)
    {
        return JawabanEvaluasiUtama::where([
            'area_evaluasi_id' => $areaEvaluasiId,
            'responden_id' => $respondenId,
            'hasil_evaluasi_id' => $hasilEvaluasiId,
            'pertanyaan_id' => $pertanyaanId
        ])->first();
    }
}
