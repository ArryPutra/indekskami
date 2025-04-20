<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class PertanyaanIKategoriSE extends Model
{
    protected $table = 'pertanyaan_i_kategori_se';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    function getJawabanResponden($respondenId, $hasilEvaluasiId, $pertanyaanId)
    {
        return JawabanIKategoriSE::where([
            'responden_id' => $respondenId,
            'hasil_evaluasi_id' => $hasilEvaluasiId,
            'pertanyaan_id' => $pertanyaanId
        ])->first();
    }
}
