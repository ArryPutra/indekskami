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
        Schema::create('jawaban_evaluasi_utama', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_evaluasi_id')->constrained('area_evaluasi');
            $table->foreignId('responden_id')->constrained('responden');
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan_evaluasi_utama');
            $table->foreignId('hasil_evaluasi_id')->constrained('hasil_evaluasi');
            $table->string('status_jawaban');
            $table->text('dokumen')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['area_evaluasi_id', 'responden_id', 'pertanyaan_id', 'hasil_evaluasi_id'], 'unique_jawaban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_evaluasi_utama');
    }
};
