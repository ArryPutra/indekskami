<?php

use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
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
        Schema::create('nilai_evaluasi_utama_responden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nilai_evaluasi_id')->constrained('nilai_evaluasi');
            $table->foreignId('nilai_evaluasi_utama_id')->constrained('nilai_evaluasi_utama');
            $table->smallInteger('total_skor')->default(0);
            $table->tinyText('status_tingkat_kematangan')->default(PertanyaanEvaluasiUtama::TINGKAT_KEMATANGAN_I);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_evaluasi_utama_responden');
    }
};
