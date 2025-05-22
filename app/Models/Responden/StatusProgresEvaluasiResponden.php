<?php

namespace App\Models\Responden;

use Illuminate\Database\Eloquent\Model;

class StatusProgresEvaluasiResponden extends Model
{
    protected $table = 'status_progres_evaluasi_responden';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Status Progres Evaluasi
    const TIDAK_MENGERJAKAN = 'Tidak Mengerjakan';
    const SEDANG_MENGERJAKAN = 'Sedang Mengerjakan';
    const SELESAI_MENGERJAKAN = 'Selesai Mengerjakan';

    const TIDAK_MENGERJAKAN_ID = 1;
    const SEDANG_MENGERJAKAN_ID = 2;
    const SELESAI_MENGERJAKAN_ID = 3;

    public static function getStatusProgresEvaluasiRespondenOptions()
    {
        return [
            self::TIDAK_MENGERJAKAN,
            self::SEDANG_MENGERJAKAN,
            self::SELESAI_MENGERJAKAN
        ];
    }
}
