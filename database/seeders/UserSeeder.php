<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'agoliganange15@gmail.com',
            'password' => Hash::make('12345678'),
            'telephone' => '0000000000',
            'photo_path' => null,
            'role_id' => 2,
            'is_active' => true,
            'birthdate' => '2000-01-01',
        ]);
    }
}
