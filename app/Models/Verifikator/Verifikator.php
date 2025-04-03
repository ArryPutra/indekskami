<?php

namespace App\Models\Verifikator;

use Illuminate\Database\Eloquent\Model;

class Verifikator extends Model
{
    protected $table = 'verifikator';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
