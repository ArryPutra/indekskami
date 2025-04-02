<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class JawabanIKategoriSE extends Model
{
    protected $table = 'jawaban_i_kategori_se';

    protected $fillable = [
        'responden_id',
        'pertanyaan_id',
        'hasil_evaluasi_id',
        'status_jawaban',
        'dokumen',
        'keterangan',
    ];
}
