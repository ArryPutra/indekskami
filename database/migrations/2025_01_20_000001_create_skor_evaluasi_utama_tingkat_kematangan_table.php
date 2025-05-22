<?php

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
        Schema::create('skor_evaluasi_utama_tingkat_kematangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_evaluasi_id')->constrained('area_evaluasi');
            $table->smallInteger('skor_minimum_tingkat_kematangan_ii');
            $table->smallInteger('skor_pencapaian_tingkat_kematangan_ii');
            $table->smallInteger('skor_minimum_tingkat_kematangan_iii')->nullable();
            $table->smallInteger('skor_pencapaian_tingkat_kematangan_iii')->nullable();
            $table->smallInteger('skor_minimum_tingkat_kematangan_iv')->nullable();
            $table->smallInteger('skor_pencapaian_tingkat_kematangan_iv')->nullable();
            $table->smallInteger('skor_minimum_tingkat_kematangan_v')->nullable();
            $table->smallInteger('skor_pencapaian_tingkat_kematangan_v')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumus_evaluasi_utama_tingkat_kematangan');
    }
};
