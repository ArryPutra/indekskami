<?php

namespace Database\Seeders;

use App\Models\Peran;
use App\Models\Superadmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nama' => 'Abdul Hafizh',
            'username' => 'superadmin',
            'email' => 'abdulhafizh@gmail.com',
            'nomor_telepon' => '082354333363',
            'peran_id' => Peran::PERAN_SUPERADMIN_ID,
            'password' => Hash::make('password123'),
        ]);

        Superadmin::create([
            'user_id' => $user->id
        ]);
    }
}
