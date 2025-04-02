<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class AreaEvaluasi extends Model
{
    protected $table = 'area_evaluasi';

    protected $guarded = ['id'];

    public function pertanyaanIKategoriSe()
    {
        return $this->hasMany(PertanyaanIKategoriSE::class, 'area_evaluasi_id', 'id');
    }

    public function pertanyaanSuplemen() {}
}
