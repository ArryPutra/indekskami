<?php

namespace Database\Seeders;

use App\Models\Manajemen\Manajemen;
use App\Models\Peran;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManajemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nama' => 'Manajemen',
            'username' => 'manajemen',
            'email' => 'manajemen@gmail.com',
            'nomor_telepon' => '08123456999',
            'peran_id' => Peran::PERAN_MANAJEMEN_ID,
            'password' => Hash::make('password123'),
        ]);

        Manajemen::create([
            'user_id' => $user->id,
            'jabatan' => 'Kepala Manajemen Indeks KAMI'
        ]);
    }
}
