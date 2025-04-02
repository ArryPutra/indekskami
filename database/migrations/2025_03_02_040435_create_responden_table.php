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
            $table->enum('daerah', ['Kabupaten/Kota', 'Provinsi']);
            $table->boolean('akses_evaluasi')->default(true);
            $table->string('status_evaluasi')->default(Responden::STATUS_BELUM);
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
