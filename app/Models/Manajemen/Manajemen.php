<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;

class Manajemen extends Model
{
    protected $table = 'manajemen';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
