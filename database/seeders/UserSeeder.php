<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ ADMIN
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'Principal',
            'email' => 'admin@kopiao.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'telephone' => '0100000000',
            'photo_path' => null,
            'role_id' => 1,
            'is_active' => true,
            'remember_token' => str()->random(10),
        ]);

        // ✅ USER TEST
        User::create([
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'agoliganange15@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'telephone' => '0000000000',
            'photo_path' => null,
            'role_id' => 2,
            'is_active' => true,
            'remember_token' => str()->random(10),
        ]);
    }
}
