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
        Schema::create('hasil_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responden_id')->constrained('responden');
            $table->foreignId('identitas_responden_id')->constrained('identitas_responden');
            $table->foreignId('nilai_evaluasi_id')->constrained('nilai_evaluasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_evaluasi');
    }
};
