<?php

namespace App\Models\Evaluasi;

use Illuminate\Database\Eloquent\Model;

class PertanyaanEvaluasiUtama extends Model
{
    protected $table = 'pertanyaan_evaluasi_utama';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const STATUS_PERTAMA = 'Tidak Dilakukan';
    const STATUS_KEDUA = 'Dalam Perencanaan';
    const STATUS_KETIGA = 'Dalam Penerapan / Diterapkan Sebagian';
    const STATUS_KEEMPAT = 'Diterapkan Secara Menyeluruh';
    const STATUS_KELIMA = 'Tidak Berlaku/Relevan';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PERTAMA,
            self::STATUS_KEDUA,
            self::STATUS_KETIGA,
            self::STATUS_KEEMPAT,
            self::STATUS_KELIMA
        ];
    }

    const TINGKAT_KEMATANGAN_I = 'I';
    const TINGKAT_KEMATANGAN_I_PLUS = 'I+';
    const TINGKAT_KEMATANGAN_II = 'II';
    const TINGKAT_KEMATANGAN_II_PLUS = 'II+';
    const TINGKAT_KEMATANGAN_III = 'III';
    const TINGKAT_KEMATANGAN_III_PLUS = 'III+';
    const TINGKAT_KEMATANGAN_IV = 'IV';
    const TINGKAT_KEMATANGAN_IV_PLUS = 'IV+';
    const TINGKAT_KEMATANGAN_V = 'V';

    public static function getTingkatKematanganOptions()
    {
        return [
            self::TINGKAT_KEMATANGAN_I,
            self::TINGKAT_KEMATANGAN_I_PLUS,
            self::TINGKAT_KEMATANGAN_II,
            self::TINGKAT_KEMATANGAN_II_PLUS,
            self::TINGKAT_KEMATANGAN_III,
            self::TINGKAT_KEMATANGAN_III_PLUS,
            self::TINGKAT_KEMATANGAN_IV,
            self::TINGKAT_KEMATANGAN_IV_PLUS,
            self::TINGKAT_KEMATANGAN_V
        ];
    }

    const PERTANYAAN_TAHAP_1 = '1';
    const PERTANYAAN_TAHAP_2 = '2';
    const PERTANYAAN_TAHAP_3 = '3';

    public static function getPertanyaanTahapOptions()
    {
        return [
            self::PERTANYAAN_TAHAP_1,
            self::PERTANYAAN_TAHAP_2,
            self::PERTANYAAN_TAHAP_3,
        ];
    }

    public function pertanyaanEvaluasi()
    {
        return $this->belongsTo(PertanyaanEvaluasi::class);
    }
}