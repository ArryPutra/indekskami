<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class PertanyaanKategoriSe extends Model
{
    protected $table = 'pertanyaan_kategori_se';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
