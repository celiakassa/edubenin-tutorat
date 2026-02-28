<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeachersSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer toutes les matières existantes
        $allSubjects = Subject::all();

        // 🔹 Listes de données
        $firstnames = ['Alex', 'Sarah', 'Marc', 'Isabelle', 'Kevin', 'Laura', 'David', 'Chantal', 'Eric', 'Mireille', 'Hugo', 'Fabienne', 'Louis', 'Arielle', 'Thomas'];
        $lastnames = ['Adjaho', 'Kpoton', 'Gandonou', 'Dossou', 'Mensah', 'Ketema', 'Houngbe', 'Assogba', 'Zinsou', 'Tokoudagba', 'Avlessi', 'Ayihoun', 'Dagba', 'Anato', 'Gbèdonou'];
        $cities = ['Cotonou', 'Porto-Novo', 'Abomey-Calavi', 'Bohicon', 'Ouidah'];
        $learning_pref = ['online', 'in_person', 'hybrid'];

        // 🔹 Génération de 15 professeurs aléatoires
        for ($i = 0; $i < 15; $i++) {
            $firstname = $firstnames[array_rand($firstnames)];
            $lastname = $lastnames[array_rand($lastnames)];

            // Génère un email aléatoire et unique
            do {
                $email = strtolower($firstname) . "." . strtolower($lastname) . rand(1000,9999) . '@example.com';
            } while (User::where('email', $email)->exists());

            $user = User::create([
                'firstname'             => $firstname,
                'lastname'              => $lastname,
                'email'                 => $email,
                'email_verified_at'     => now(),
                'password'              => Hash::make('password123'),
                'telephone'             => '+229' . rand(90000000, 99999999),
                'photo_path'            => null,
                'role_id'               => 3,
                'is_active'             => 1,
                'remember_token'        => Str::random(10),
                'created_at'            => now(),
                'updated_at'            => now(),
                'bio'                   => null,
                'qualifications'        => null,
                'rate_per_hour'         => rand(1000, 5000),
                'identity_document_path'=> 'pieceidentite/dummy.pdf',
                'identity_verified'     => 1,
                'availability'          => null,
                'city'                  => $cities[array_rand($cities)],
                'learning_history'      => null,
                'learning_preference'   => $learning_pref[array_rand($learning_pref)],
                'satisfaction_score'    => null,
                'notify_email'          => 1,
                'notify_push'           => 1,
                'last_login'            => null,
                'is_valid'              => 1,
            ]);

            // Assigner 1 à 3 matières aléatoires à chaque tuteur
            $randomSubjects = $allSubjects->random(rand(1, 3))->pluck('id')->toArray();
            $user->subjects()->attach($randomSubjects);
        }
    }
}
