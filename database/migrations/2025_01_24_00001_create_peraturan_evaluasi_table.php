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
        Schema::create('peraturan_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('maksimal_ukuran_dokumen');
            $table->json('daftar_ekstensi_dokumen_valid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peraturan_evaluasi');
    }
};
