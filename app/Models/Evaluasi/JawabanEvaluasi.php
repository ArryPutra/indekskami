<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class JawabanEvaluasi extends Model
{
    protected $table = 'jawaban_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const STATUS_PERTAMA = 'status_pertama';
    const STATUS_KEDUA = 'status_kedua';
    const STATUS_KETIGA = 'status_ketiga';
    const STATUS_KEEMPAT = 'status_keempat';
    const STATUS_KELIMA = 'status_kelima';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PERTAMA,
            self::STATUS_KEDUA,
            self::STATUS_KETIGA,
            self::STATUS_KEEMPAT,
            self::STATUS_KELIMA
        ];
    }

    public function pertanyaanEvaluasi()
    {
        return $this->belongsTo(PertanyaanEvaluasi::class);
    }
}
