<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Verifikator\Verifikator;
use Database\Factories\UserFactory;
use Database\Factories\VerifikatorFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VerifikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // UserFactory::new()
        //     ->count(15)
        //     ->has(VerifikatorFactory::new()->count(1))
        //     ->create();

        $user = User::create([
            'nama' => 'Ahmad Hadi',
            'username' => 'ahmadhadi',
            'email' => 'ahmadhadi@gmail.com',
            'nomor_telepon' => '08134567899',
            'peran_id' => 2,
            'password' => Hash::make('password123'),
            'apakah_akun_nonaktif' => false
        ]);

        Verifikator::create([
            'user_id' => $user->id,
            'nomor_sk' => '123456789',
        ]);
    }
}
