<?php

namespace App\Models\Responden;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    protected $table = 'responden';

    protected $fillable = [
        'user_id',
        'daerah',
        'akses_evaluasi',
        'status_evaluasi'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // Status Evaluasi
    const STATUS_BELUM = 'Belum';
    const STATUS_MENGERJAKAN = 'Mengerjakan';
    const STATUS_SELESAI = 'Selesai';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_BELUM,
            self::STATUS_MENGERJAKAN,
            self::STATUS_SELESAI,
        ];
    }
}
