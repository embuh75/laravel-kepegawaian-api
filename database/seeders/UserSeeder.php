<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(User $user): void
    {
        $data = [
            [
                'name' => 'Admin',
                'role' => 'admin',
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => 'Admin123',
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'User',
                'role' => 'user',
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => 'User123',
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($data as $array) {
            $user->create($array);
        }

    }
}
