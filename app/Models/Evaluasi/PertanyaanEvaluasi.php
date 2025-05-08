<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class PertanyaanEvaluasi extends Model
{
    protected $table = 'pertanyaan_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pertanyaanKategoriSe()
    {
        return $this->hasOne(PertanyaanKategoriSe::class);
    }
    public function pertanyaanEvaluasiUtama()
    {
        return $this->hasOne(PertanyaanEvaluasiUtama::class);
    }
    public function pertanyaanSuplemen()
    {
        return $this->hasOne(PertanyaanSuplemen::class);
    }
}
