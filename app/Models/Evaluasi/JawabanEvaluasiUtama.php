<?php

namespace App\Models\Evaluasi;

use App\Models\KepemilikanDokumen;
use Illuminate\Database\Eloquent\Model;

class JawabanEvaluasiUtama extends Model
{
    protected $table = 'jawaban_evaluasi_utama';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Status
    const SKOR_STATUS_PERTAMA = 'skor_status_pertama';
    const SKOR_STATUS_KEDUA = 'skor_status_kedua';
    const SKOR_STATUS_KETIGA = 'skor_status_ketiga';
    const SKOR_STATUS_KEEMPAT = 'skor_status_keempat';
    const SKOR_STATUS_KELIMA = 'skor_status_kelima';

    public static function getStatusOptions()
    {
        return [
            self::SKOR_STATUS_PERTAMA,
            self::SKOR_STATUS_KEDUA,
            self::SKOR_STATUS_KETIGA,
            self::SKOR_STATUS_KEEMPAT,
            self::SKOR_STATUS_KELIMA,
        ];
    }

    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanEvaluasiUtama::class, 'pertanyaan_id', 'id');
    }

    public static function getKepemilikanDokumen($respondenId, $hasilEvaluasiId, $areaEvaluasiId, $pertanyaanId)
    {
        return KepemilikanDokumen::where('responden_id', $respondenId)
            ->where('hasil_evaluasi_id', $hasilEvaluasiId)
            ->where('area_evaluasi_id', $areaEvaluasiId)
            ->where('pertanyaan_id', $pertanyaanId);
    }
}
