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
        Schema::create('identitas_responden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responden_id')->constrained('responden')->onDelete('cascade');
            $table->enum('identitas_instansi', ['Satuan Kerja', 'Direktorat', 'Departemen']);
            $table->text('alamat');
            $table->string('nomor_telepon');
            $table->string('email');
            $table->string('pengisi_lembar_evaluasi');
            $table->string('jabatan');
            $table->string('tanggal_pengisian');
            $table->text('deskripsi_ruang_lingkup');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_responden');
    }
};
