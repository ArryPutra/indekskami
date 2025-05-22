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
        Schema::create('jawaban_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responden_id')->constrained('responden');
            $table->foreignId('pertanyaan_evaluasi_id')->constrained('pertanyaan_evaluasi');
            $table->foreignId('hasil_evaluasi_id')->constrained('hasil_evaluasi');
            $table->string('status_jawaban');
            $table->text('bukti_dokumen')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['pertanyaan_evaluasi_id', 'hasil_evaluasi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_evaluasi');
    }
};
