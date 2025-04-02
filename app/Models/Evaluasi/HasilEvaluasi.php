<?php

namespace App\Models\Evaluasi;

use App\Models\Responden\IdentitasResponden;
use Illuminate\Database\Eloquent\Model;

class HasilEvaluasi extends Model
{
    protected $table = 'hasil_evaluasi';

    protected $fillable = [
        'responden_id',
        'identitas_responden_id',
        'nilai_evaluasi_id'
    ];

    public function identitasResponden()
    {
        return $this->hasOne(IdentitasResponden::class, 'id', 'identitas_responden_id');
    }

    public function jawabanIKategoriSE()
    {
        return $this->hasMany(JawabanIKategoriSE::class, 'hasil_evaluasi_id', 'id');
    }
}
