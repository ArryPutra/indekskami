<?php

use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
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
            $table->foreignId('responden_id')->constrained('responden');
            $table->smallInteger('skor_kategori_se')->default(0);
            $table->string('kategori_se')->default(NilaiEvaluasi::KATEGORI_SE_RENDAH);
            $table->string('hasil_evaluasi_akhir')->default(NilaiEvaluasi::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK);
            $table->smallInteger('tingkat_kelengkapan_iso')->default(0);
            $table->smallInteger('pengamanan_keterlibatan_pihak_ketiga')->default(0);
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
