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
        Schema::create('pertanyaan_i_kategori_se', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_evaluasi_id')->constrained('area_evaluasi');
            $table->unsignedTinyInteger('nomor');
            $table->text('pertanyaan');
            $table->string('status_pertama');
            $table->string('status_kedua');
            $table->string('status_ketiga');
            $table->tinyInteger('skor_status_pertama')->default(5);
            $table->tinyInteger('skor_status_kedua')->default(2);
            $table->tinyInteger('skor_status_ketiga')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_i_kategori_se');
    }
};
