<?php

use App\Models\Responden\Responden;
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
        Schema::create('responden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('status_progres_evaluasi_responden_id')
                ->constrained('status_progres_evaluasi_responden')->default(1);
            $table->enum('daerah', ['Kabupaten/Kota', 'Provinsi']);
            $table->text('alamat');
            $table->boolean('akses_evaluasi')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responden');
    }
};
