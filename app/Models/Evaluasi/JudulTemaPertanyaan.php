<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class JudulTemaPertanyaan extends Model
{
    protected $table = 'judul_tema_pertanyaan';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
