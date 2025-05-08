<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class StatusHasilEvaluasi extends Model
{
    protected $table = 'status_hasil_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const STATUS_DIKERJAKAN = 'Dikerjakan'; // sedang dikerjakan responden
    const STATUS_DIREVISI = 'Direvisi'; // responden melakukan ulang evaluasi
    const STATUS_DITOLAK = 'Ditolak'; // evaluasi responden tidak diterima/dilanjutkan
    const STATUS_DITINJAU = 'Ditinjau'; // evaluasi sudah diterima, sedang ditinjau oleh verifikator
    const STATUS_SELESAI = 'Selesai'; // evaluasi sudah tuntas semuanya

    const STATUS_DIKERJAKAN_ID = 1;
    const STATUS_DIREVISI_ID = 2;
    const STATUS_DITOLAK_ID = 3;
    const STATUS_DITINJAU_ID = 4;
    const STATUS_SELESAI_ID = 5;

    public static function getStatusHasilEvaluasiOptions()
    {
        return [
            self::STATUS_DIKERJAKAN,
            self::STATUS_DIREVISI,
            self::STATUS_DITOLAK,
            self::STATUS_DITINJAU,
            self::STATUS_SELESAI
        ];
    }
}
