<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = 'peran';

    protected $fillable = [
        'nama_peran'
    ];

    // Peran
    const PERAN_ADMIN = 'Admin';
    const PERAN_VERIFIKATOR = 'Verifikator';
    const PERAN_RESPONDEN = 'Responden';
    const PERAN_PENINJAU = 'Peninjau';
}
