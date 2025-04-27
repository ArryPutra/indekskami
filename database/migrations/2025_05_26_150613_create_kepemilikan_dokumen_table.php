<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kepemilikan_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responden_id')->constrained('responden');
            $table->foreignId('hasil_evaluasi_id')->constrained('hasil_evaluasi');
            $table->foreignId('area_evaluasi_id')->constrained('area_evaluasi');
            $table->bigInteger('pertanyaan_id');
            $table->string('path');
            $table->timestamps();

            $table->unique(['responden_id', 'hasil_evaluasi_id', 'area_evaluasi_id', 'pertanyaan_id'], 'kepemilikan_dokumen_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepemilikan_dokumen');
    }
};
