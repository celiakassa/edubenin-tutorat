<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $teachers = [
            [
                'firstname' => 'Alexandro',
                'lastname' => 'Cocouvi',
                'email' => 'alexandro@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 3,
                'is_active' => true,
                'subjects' => json_encode(['Maths', 'Physics']),
                'city' => 'Cotonou',
                'learning_preference' => 'online',
                'birthdate' => '1990-05-15',
            ],
            [
                'firstname' => 'Marie',
                'lastname' => 'Dupont',
                'email' => 'marie@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 3,
                'is_active' => true,
                'subjects' => json_encode(['English', 'French']),
                'city' => 'Porto-Novo',
                'learning_preference' => 'in_person',
                'birthdate' => '1990-05-15',
            ],
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 3,
                'is_active' => true,
                'subjects' => json_encode(['Computer Science']),
                'city' => 'Cotonou',
                'learning_preference' => 'online',
                'birthdate' => '1990-05-15',
            ],
        ];
        foreach ($teachers as $teacher) {
            User::create($teacher);
        }
    }
}
