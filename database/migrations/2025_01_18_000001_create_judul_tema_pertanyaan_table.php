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
        Schema::create('judul_tema_pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_evaluasi_id');
            $table->string('judul');
            $table->integer('letakkan_sebelum_nomor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judul_tema_pertanyaan');
    }
};
