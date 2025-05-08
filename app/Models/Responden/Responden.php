<?php

namespace App\Models\Responden;

use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    protected $table = 'responden';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function hasilEvaluasi()
    {
        return $this->hasMany(HasilEvaluasi::class, 'responden_id', 'id');
    }

    public function statusProgresEvaluasi()
    {
        return $this->belongsTo(StatusProgresEvaluasi::class);
    }

    // Identitas Instansi
    const IDENTITAS_INSTANSI_SATUAN_KERJA = 'Satuan Kerja';
    const IDENTITAS_INSTANSI_DIREKTORAT = 'Direktorat';
    const IDENTITAS_INSTANSI_DEPARTEMEN = 'Departemen';

    public static function getIdentitasInstansiOptions()
    {
        return [
            self::IDENTITAS_INSTANSI_SATUAN_KERJA,
            self::IDENTITAS_INSTANSI_DIREKTORAT,
            self::IDENTITAS_INSTANSI_DEPARTEMEN
        ];
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
