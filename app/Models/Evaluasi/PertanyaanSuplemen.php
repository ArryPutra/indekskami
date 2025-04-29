<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class PertanyaanSuplemen extends Model
{
    protected $table = 'pertanyaan_suplemen';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const STATUS_PERTAMA = 'Tidak Dilakukan';
    const STATUS_KEDUA = 'Dalam Perencanaan';
    const STATUS_KETIGA = 'Dalam Penerapan / Diterapkan Sebagian';
    const STATUS_KEEMPAT = 'Diterapkan Secara Menyeluruh';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PERTAMA,
            self::STATUS_KEDUA,
            self::STATUS_KETIGA,
            self::STATUS_KEEMPAT
        ];
    }

    const SKOR_STATUS_PERTAMA = 0;
    const SKOR_STATUS_KEDUA = 1;
    const SKOR_STATUS_KETIGA = 2;
    const SKOR_STATUS_KEEMPAT = 3;

    public static function getSkorStatusOptions()
    {
        return [
            self::SKOR_STATUS_PERTAMA,
            self::SKOR_STATUS_KEDUA,
            self::SKOR_STATUS_KETIGA,
            self::SKOR_STATUS_KEEMPAT
        ];
    }
}
