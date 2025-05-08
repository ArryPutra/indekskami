<?php

namespace App\Models\Evaluasi;

use App\Models\Responden\IdentitasResponden;
use App\Models\Responden\Responden;
use Illuminate\Database\Eloquent\Model;

class HasilEvaluasi extends Model
{
    protected $table = 'hasil_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function responden()
    {
        return $this->hasOne(Responden::class, 'id', 'responden_id');
    }

    public function identitasResponden()
    {
        return $this->hasOne(IdentitasResponden::class, 'id', 'identitas_responden_id');
    }

    public function jawabanEvaluasi()
    {
        return $this->hasMany(JawabanEvaluasi::class, 'hasil_evaluasi_id', 'id');
    }
}
