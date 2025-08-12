<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PublicUserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'ic_number' => '901234567890',
            'email' => fake()->unique()->safeEmail(),
            'phone' => '012' . fake()->numerify('#######'),
            'address' => fake()->address(),
            'postcode' => fake()->postcode(),
            'city' => fake()->city(),
            'state' => 'Negeri Sembilan',
            'date_of_birth' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'occupation' => fake()->jobTitle(),
            'household_size' => fake()->numberBetween(1, 6),
            'preferred_language' => 'malay',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => fake()->randomString(10),
        ];
    }
}