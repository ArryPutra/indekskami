<?php

namespace App\Models\Responden;

use Illuminate\Database\Eloquent\Model;

class StatusProgresEvaluasi extends Model
{
    protected $table = 'status_progres_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Status Evaluasi
    const BELUM_MEMULAI = 'Belum Memulai';
    const SEDANG_MENGERJAKAN = 'Sedang Mengerjakan';
    const SELESAI_MENGERJAKAN = 'Selesai Mengerjakan';

    public static function getStatusProgresEvaluasiOptions()
    {
        return [
            self::BELUM_MEMULAI,
            self::SEDANG_MENGERJAKAN,
            self::SELESAI_MENGERJAKAN
        ];
    }
}
