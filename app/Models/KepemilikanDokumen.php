<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepemilikanDokumen extends Model
{
    protected $table = 'kepemilikan_dokumen';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
