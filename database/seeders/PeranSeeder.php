<?php

namespace Database\Seeders;

use App\Models\Peran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarNamaPeran = ['Admin', 'Responden', 'Verifikator'];

        foreach ($daftarNamaPeran as $namaPeran) {
            Peran::create([
                'nama_peran' => $namaPeran
            ]);
        }
    }
}
