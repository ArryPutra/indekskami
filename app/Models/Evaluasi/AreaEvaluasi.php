<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class AreaEvaluasi extends Model
{
    protected $table = 'area_evaluasi';

    protected $guarded = ['id'];

    public function tipeEvaluasi()
    {
        return $this->belongsTo(TipeEvaluasi::class, 'tipe_evaluasi_id', 'id');
    }

    public function pertanyaanIKategoriSe()
    {
        return $this->hasMany(PertanyaanIKategoriSE::class, 'area_evaluasi_id', 'id');
    }

    public function pertanyaanEvaluasiUtama()
    {
        return $this->hasMany(PertanyaanEvaluasiUtama::class, 'area_evaluasi_id', 'id');
    }

    public function pertanyaanSuplemen() {}
}
