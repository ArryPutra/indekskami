<?php

namespace Database\Seeders;

use App\Models\Peran;
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
            'nama' => 'Ahim Kurniawan',
            'username' => 'ahimkurniawan',
            'email' => 'ahimkurniawan@gmailcom',
            'nomor_telepon' => '08134567899',
            'peran_id' => Peran::PERAN_VERIFIKATOR_ID,
            'password' => Hash::make('password123'),
            'apakah_akun_nonaktif' => false
        ]);

        Verifikator::create([
            'user_id' => $user->id,
            'nomor_sk' => '045/SK/FTUI/IV/2023',
        ]);
    }
}
