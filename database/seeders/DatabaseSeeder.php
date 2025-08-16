<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user (only if doesn't exist)
        if (!User::where('email', 'admin@zunitabegum.my')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@zunitabegum.my',
                'password' => bcrypt('password'),
            ]);
        }

        // Seed the public user system with realistic data
        $this->call([
            PublicUserSystemSeeder::class,
            PageSeeder::class,
        ]);
    }
}
