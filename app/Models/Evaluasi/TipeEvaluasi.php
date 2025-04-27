<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class TipeEvaluasi extends Model
{
    protected $table = 'tipe_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const KATEGORI_SISTEM_ELEKTRONIK = 'Kategori Sistem Elektronik';
    const EVALUASI_UTAMA = 'Evaluasi Utama';
    const SUPLEMEN = 'Suplemen';
}
