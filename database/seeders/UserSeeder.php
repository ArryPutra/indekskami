<?php

namespace Database\Seeders;

use App\Models\Responden\Responden;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'nomor_telepon' => '08123456789',
            'peran_id' => 1,
            'password' => Hash::make('password123'),
        ]);
    }
}
