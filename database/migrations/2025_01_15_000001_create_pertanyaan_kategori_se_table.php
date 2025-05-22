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
        Schema::create('pertanyaan_kategori_se', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pertanyaan_evaluasi_id')->constrained('pertanyaan_evaluasi');
            $table->string('status_pertama');
            $table->string('status_kedua');
            $table->string('status_ketiga');
            $table->tinyInteger('skor_status_pertama');
            $table->tinyInteger('skor_status_kedua');
            $table->tinyInteger('skor_status_ketiga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_kategori_se');
    }
};
