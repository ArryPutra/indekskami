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
        Schema::create('nilai_evaluasi_utama', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_evaluasi_id')->constrained('area_evaluasi');
            $table->string('nama_nilai_evaluasi_utama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_evaluasi_utama');
    }
};
