<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class JawabanIKategoriSE extends Model
{
    protected $table = 'jawaban_i_kategori_se';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Status
    const SKOR_STATUS_PERTAMA = 'skor_status_pertama';
    const SKOR_STATUS_KEDUA = 'skor_status_kedua';
    const SKOR_STATUS_KETIGA = 'skor_status_ketiga';

    public static function getStatusOptions()
    {
        return [
            self::SKOR_STATUS_PERTAMA,
            self::SKOR_STATUS_KEDUA,
            self::SKOR_STATUS_KETIGA
        ];
    }
}
