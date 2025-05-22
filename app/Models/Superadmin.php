<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Superadmin extends Model
{
    protected $table = 'superadmin';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
