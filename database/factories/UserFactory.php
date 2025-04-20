<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'nomor_telepon' => fake()->unique()->phoneNumber(),
            'peran_id' => 2,
            'password' => Hash::make('password123'),
            'apakah_akun_nonaktif' => fake()->boolean()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function withPeran($peranId)
    {
        return $this->state(function (array $attributes) use ($peranId) {
            return [
                'peran_id' => $peranId
            ];
        });
    }
}
