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
            $table->smallInteger('nomor');
            $table->text('pertanyaan');
            $table->string('status_a');
            $table->string('status_b');
            $table->string('status_c');
            $table->tinyInteger('skor_status_a')->default(5);
            $table->tinyInteger('skor_status_b')->default(2);
            $table->tinyInteger('skor_status_c')->default(1);
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
