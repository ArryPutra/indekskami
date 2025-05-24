<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\PeraturanEvaluasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeraturanEvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PeraturanEvaluasi::create([
            'maksimal_ukuran_dokumen' => 10,
            'daftar_ekstensi_dokumen_valid' => json_encode(
                ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'rar', '7z']
            )
        ]);
    }
}
