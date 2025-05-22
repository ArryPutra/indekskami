<?php

namespace App\Models\Responden;

use Illuminate\Database\Eloquent\Model;

class StatusHasilEvaluasi extends Model
{
    protected $table = 'status_hasil_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const STATUS_DIKERJAKAN = 'Dikerjakan'; // sedang dikerjakan responden
    const STATUS_DITINJAU = 'Ditinjau'; // evaluasi sudah dikirim, sedang ditinjau oleh verifikator
    const STATUS_DIVERIFIKASI = 'Diverifikasi'; // evaluasi sudah selesai semuanya dan terverifikasi
    
    const STATUS_DIKERJAKAN_ID = 1;
    const STATUS_DITINJAU_ID = 2;
    const STATUS_DIVERIFIKASI_ID = 3;

    public static function getStatusHasilEvaluasiOptions()
    {
        return [
            self::STATUS_DIKERJAKAN,
            self::STATUS_DITINJAU,
            self::STATUS_DIVERIFIKASI,
        ];
    }
}