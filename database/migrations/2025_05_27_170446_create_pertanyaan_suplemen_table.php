<?php

use App\Models\Evaluasi\PertanyaanSuplemen;
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
        Schema::create('pertanyaan_suplemen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_evaluasi_id')->constrained('area_evaluasi');
            $table->unsignedSmallInteger('nomor');
            $table->text('catatan')->nullable();
            $table->text('pertanyaan');
            $table->string('status_pertama')->default(PertanyaanSuplemen::STATUS_PERTAMA);
            $table->string('status_kedua')->default(PertanyaanSuplemen::STATUS_KEDUA);
            $table->string('status_ketiga')->default(PertanyaanSuplemen::STATUS_KETIGA);
            $table->string('status_keempat')->default(PertanyaanSuplemen::STATUS_KEEMPAT);
            $table->tinyInteger('skor_status_pertama')->default(PertanyaanSuplemen::SKOR_STATUS_PERTAMA);
            $table->tinyInteger('skor_status_kedua')->default(PertanyaanSuplemen::SKOR_STATUS_KEDUA);
            $table->tinyInteger('skor_status_ketiga')->default(PertanyaanSuplemen::SKOR_STATUS_KETIGA);
            $table->tinyInteger('skor_status_keempat')->default(PertanyaanSuplemen::SKOR_STATUS_KEEMPAT);
            $table->boolean('apakah_tampil')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_suplemen');
    }
};
