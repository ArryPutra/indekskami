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
        Schema::create('pertanyaan_evaluasi_utama', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_evaluasi_id')->constrained('area_evaluasi');
            $table->unsignedSmallInteger('nomor');
            $table->text('catatan')->nullable();
            $table->tinyText('tingkat_kematangan');
            $table->unsignedTinyInteger('pertanyaan_tahap');
            $table->text('pertanyaan');
            $table->string('status_pertama');
            $table->string('status_kedua');
            $table->string('status_ketiga');
            $table->string('status_keempat');
            $table->string('status_kelima')->nullable();
            $table->tinyInteger('skor_status_pertama');
            $table->tinyInteger('skor_status_kedua');
            $table->tinyInteger('skor_status_ketiga');
            $table->tinyInteger('skor_status_keempat');
            $table->tinyInteger('skor_status_kelima')->nullable();
            $table->boolean('apakah_tampil')->default(true);
            $table->timestamps();

            $table->unique(['nomor', 'area_evaluasi_id', 'apakah_tampil'], 'nomor_area_evaluasi_apakah_tampil_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_evaluasi_utama');
    }
};
