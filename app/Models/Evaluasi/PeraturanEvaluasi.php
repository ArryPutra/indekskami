<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class PeraturanEvaluasi extends Model
{
    protected $table = 'peraturan_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
