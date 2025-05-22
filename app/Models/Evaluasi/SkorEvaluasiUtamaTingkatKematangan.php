<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class SkorEvaluasiUtamaTingkatKematangan extends Model
{
    protected $table = 'skor_evaluasi_utama_tingkat_kematangan';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function areaEvaluasi()
    {
        return $this->hasOne(AreaEvaluasi::class, 'id', 'area_evaluasi_id');
    }
}
