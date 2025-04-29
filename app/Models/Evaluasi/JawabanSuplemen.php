<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class JawabanSuplemen extends Model
{
    protected $table = 'jawaban_suplemen';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Status
    const SKOR_STATUS_PERTAMA = 'skor_status_pertama';
    const SKOR_STATUS_KEDUA = 'skor_status_kedua';
    const SKOR_STATUS_KETIGA = 'skor_status_ketiga';
    const SKOR_STATUS_KEEMPAT = 'skor_status_keempat';

    public static function getStatusOptions()
    {
        return [
            self::SKOR_STATUS_PERTAMA,
            self::SKOR_STATUS_KEDUA,
            self::SKOR_STATUS_KETIGA,
            self::SKOR_STATUS_KEEMPAT
        ];
    }
}
