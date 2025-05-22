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
        Schema::create('area_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipe_evaluasi_id')->constrained('tipe_evaluasi');
            $table->string('nama_area_evaluasi')->unique();
            $table->string('judul');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_evaluasi');
    }
};
