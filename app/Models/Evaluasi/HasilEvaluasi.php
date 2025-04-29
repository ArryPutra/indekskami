<?php

namespace App\Models\Evaluasi;

use App\Models\Responden\IdentitasResponden;
use App\Models\Responden\Responden;
use Illuminate\Database\Eloquent\Model;

class HasilEvaluasi extends Model
{
    protected $table = 'hasil_evaluasi';

    protected $fillable = [
        'responden_id',
        'identitas_responden_id',
        'nilai_evaluasi_id'
    ];

    const STATUS_DIKERJAKAN = 'Dikerjakan';
    const STATUS_DIREVISI = 'Direvisi';
    const STATUS_DITOLAK = 'Ditolak';
    const STATUS_DITERIMA = 'Diterima';

    public function responden()
    {
        return $this->hasOne(Responden::class, 'id', 'responden_id');
    }

    public function identitasResponden()
    {
        return $this->hasOne(IdentitasResponden::class, 'id', 'identitas_responden_id');
    }

    public function jawabanIKategoriSE()
    {
        return $this->hasMany(JawabanIKategoriSE::class, 'hasil_evaluasi_id', 'id');
    }

    public function jawabanEvaluasiUtama()
    {
        return $this->hasMany(JawabanEvaluasiUtama::class, 'hasil_evaluasi_id', 'id');
    }

    public function jawabanSuplemen()
    {
        return $this->hasMany(JawabanSuplemen::class, 'hasil_evaluasi_id', 'id');
    }
}
