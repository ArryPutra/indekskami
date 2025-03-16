<?php

namespace App\Models\Responden;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class IdentitasResponden extends Model
{
    protected $table = 'identitas_responden';

    protected $fillable = [
        'responden_id',
        'identitas_instansi',
        'alamat',
        'nomor_telepon',
        'email',
        'pengisi_lembar_evaluasi',
        'jabatan',
        'tanggal_pengisian',
        'deskripsi_ruang_lingkup',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
