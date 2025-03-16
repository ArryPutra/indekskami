<?php

use App\Models\Responden\NilaiEvaluasi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responden_id')->constrained('responden')->onDelete('cascade');
            $table->foreignId('identitas_responden_id')->constrained('users')->onDelete('cascade');
            $table->integer('skor_kategori_se')->default(0);
            $table->string('kategori_se')->default(NilaiEvaluasi::SKOR_KATEGORI_SE_RENDAH);
            $table->string('hasil_evaluasi_akhir')->default(NilaiEvaluasi::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK);
            $table->string('tingkat_kelengkapan_iso')->default(0);
            $table->string('tata_kelola')->default(0);
            $table->string('pengelolaan_risiko')->default(0);
            $table->string('kerangka_kerja_keamanan_informasi')->default(0);
            $table->string('teknologi_dan_keamanan_informasi')->default(0);
            $table->string('perlindungan_data_pribadi')->default(0);
            $table->string('pengamanan_keterlibatan_pihak_ketiga')->default(0);
            $table->string('t_kematangan_tata_kelola')->default(NilaiEvaluasi::T_KEMATANGAN_I);
            $table->string('t_kematangan_pengelolaan_risiko')->default(NilaiEvaluasi::T_KEMATANGAN_I);
            $table->string('t_kematangan_kerangka_kerja_keamanan_informasi')->default(NilaiEvaluasi::T_KEMATANGAN_I);
            $table->string('t_kematangan_pengelolaan_aset')->default(NilaiEvaluasi::T_KEMATANGAN_I);
            $table->string('t_kematangan_teknologi_dan_keamanan_informasi')->default(NilaiEvaluasi::T_KEMATANGAN_I);
            $table->string('t_kematangan_perlindungan_data_pribadi')->default(NilaiEvaluasi::T_KEMATANGAN_I);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_evaluasi');
    }
};
