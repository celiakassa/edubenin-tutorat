<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'firstname'        => 'Test',
            'lastname'         => 'User',
            'email'            => 'agoliganange15@gmail.com',
            'email_verified_at'=> now(),
            'password'         => Hash::make('12345678'),
            'telephone'        => '0000000000',
            'photo_path'       => null,
            'role_id'          => 3,
            'is_active'        => true,
            'remember_token'   => str()->random(10),
        ]);
    }
}
