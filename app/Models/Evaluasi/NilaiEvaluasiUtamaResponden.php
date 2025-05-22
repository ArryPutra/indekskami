<?php

namespace App\Models\Evaluasi;

use App\Models\Responden\NilaiEvaluasi;
use Illuminate\Database\Eloquent\Model;

class NilaiEvaluasiUtamaResponden extends Model
{
    protected $table = 'nilai_evaluasi_utama_responden';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function nilaiEvaluasiUtama()
    {
        return $this->belongsTo(NilaiEvaluasiUtama::class);
    }

    public static function getNilaiEvaluasiUtama($nilaiEvaluasiUtamaResponden)
    {
        return $nilaiEvaluasiUtamaResponden->map(function ($nilaiEvaluasiUtamaResponden) {
            return [
                'namaNilaiEvaluasiUtama'
                => $nilaiEvaluasiUtamaResponden->nilaiEvaluasiUtama->nama_nilai_evaluasi_utama,
                'skorStatusTingkatKematangan'
                => NilaiEvaluasi::getSkorTingkatKematangan($nilaiEvaluasiUtamaResponden->status_tingkat_kematangan)
            ];
        });
    }
}
