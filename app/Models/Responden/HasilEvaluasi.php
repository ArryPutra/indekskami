<?php

namespace App\Models\Responden;

use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Responden\JawabanEvaluasi;
use App\Models\Responden\IdentitasResponden;
use App\Models\Responden\NilaiEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Verifikator\Verifikator;
use Illuminate\Database\Eloquent\Model;

class HasilEvaluasi extends Model
{
    protected $table = 'hasil_evaluasi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function responden()
    {
        return $this->hasOne(Responden::class, 'id', 'responden_id');
    }

    public function identitasResponden()
    {
        return $this->hasOne(IdentitasResponden::class, 'id', 'identitas_responden_id');
    }

    public function nilaiEvaluasi()
    {
        return $this->hasOne(NilaiEvaluasi::class, 'id', 'identitas_responden_id');
    }

    public function jawabanEvaluasi()
    {
        return $this->hasMany(JawabanEvaluasi::class, 'hasil_evaluasi_id', 'id');
    }

    public function statusHasilEvaluasi()
    {
        return $this->belongsTo(StatusHasilEvaluasi::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(Verifikator::class);
    }

    public static function verifikasiHasilEvaluasi(HasilEvaluasi $hasilEvaluasi)
    {
        // Memperbarui status Hasil Evaluasi
        $hasilEvaluasi->update([
            'status_hasil_evaluasi_id' => StatusHasilEvaluasi::where('nama_status_hasil_evaluasi', 'Diverifikasi')->value('id')
        ]);

        // Memperbarui status Responden
        $hasilEvaluasi->responden->update([
            'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::where('nama_status_progres_evaluasi_responden', StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN)->value('id')
        ]);
    }

    public static function getProgresEvaluasiTerjawab(
        HasilEvaluasi $hasilEvaluasi
    ) {
        $hasilEvaluasi->load('jawabanEvaluasi.pertanyaanEvaluasi');

        $jumlahJawabanResponden = $hasilEvaluasi->jawabanEvaluasi->filter(
            fn($jawaban) => $jawaban->pertanyaanEvaluasi->apakah_tampil === 1
        )->count();
        $jumlahPertanyaanEvaluasi = PertanyaanEvaluasi::where('apakah_tampil', true)->count();

        $persentaseJawabanResponden = round($jumlahJawabanResponden / $jumlahPertanyaanEvaluasi * 100, 2);

        return [
            'label' => "$jumlahJawabanResponden/$jumlahPertanyaanEvaluasi Terjawab ($persentaseJawabanResponden%)",
            'persen' => $persentaseJawabanResponden
        ];
    }
}
