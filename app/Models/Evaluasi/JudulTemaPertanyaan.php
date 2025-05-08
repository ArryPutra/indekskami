<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class JudulTemaPertanyaan extends Model
{
    protected $table = 'judul_tema_pertanyaan';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Tipe Evaluasi
    const KATEGORI_SISTEM_ELEKTRONIK = 'Kategori Sistem Elektronik';
    const EVALUASI_UTAMA = 'Evaluasi Utama';
    const SUPLEMEN = 'Suplemen';

    public static function getTipeEvaluasiOptions()
    {
        return [
            self::KATEGORI_SISTEM_ELEKTRONIK,
            self::EVALUASI_UTAMA,
            self::SUPLEMEN
        ];
    }
}
