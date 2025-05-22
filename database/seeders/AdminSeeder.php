<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use App\Models\Peran;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'nomor_telepon' => '08123456799',
            'peran_id' => Peran::PERAN_ADMIN_ID,
            'password' => Hash::make('password123'),
        ]);

        Admin::create([
            'user_id' => $user->id
        ]);
    }
}