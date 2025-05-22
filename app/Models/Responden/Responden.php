<?php

namespace App\Models\Responden;

use App\Models\Responden\StatusHasilEvaluasi;
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

    public function statusProgresEvaluasiResponden()
    {
        return $this->belongsTo(StatusProgresEvaluasiResponden::class);
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

    public static function getHasilEvaluasiDikerjakan($responden)
    {
        return $responden->hasilEvaluasi->where(
            'status_hasil_evaluasi_id',
            StatusHasilEvaluasi::where('nama_status_hasil_evaluasi', StatusHasilEvaluasi::STATUS_DIKERJAKAN)->value('id')
        )->first();
    }
}
