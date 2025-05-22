<?php

namespace App\Models\Responden;

use App\Models\Responden\HasilEvaluasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class IdentitasResponden extends Model
{
    protected $table = 'identitas_responden';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Identitas
    const SATUAN_KERJA = 'Satuan Kerja';
    const DIREKTORAT = 'Direktorat';
    const DEPARTEMEN = 'Departemen';

    public static function getIdentitasOptions()
    {
        return [
            self::SATUAN_KERJA,
            self::DIREKTORAT,
            self::DEPARTEMEN,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function hasilEvaluasi()
    {
        return $this->hasOne(HasilEvaluasi::class, 'identitas_responden_id', 'id');
    }
}
