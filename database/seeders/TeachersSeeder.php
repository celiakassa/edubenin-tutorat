<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeachersSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Ajouter l'admin par défaut
        User::create([
            'firstname'             => 'Admin',
            'lastname'              => 'System',
            'email'                 => 'admin@gmail.com',
            'email_verified_at'     => now(),
            'password'              => Hash::make('12345678'),
            'telephone'             => null,
            'photo_path'            => null,
            'role_id'               => 1,
            'is_active'             => 1,
            'remember_token'        => Str::random(10),
            'created_at'            => now(),
            'updated_at'            => now(),
            'bio'                   => null,
            'qualifications'        => null,
            'subjects'              => json_encode([]),
            'rate_per_hour'         => null,
            'identity_document_path'=> null,
            'identity_verified'     => 0,
            'availability'          => null,
            'city'                  => 'Cotonou',
            'learning_history'      => null,
            'learning_preference'   => 'online',
            'satisfaction_score'    => null,
            'notify_email'          => 1,
            'notify_push'           => 1,
            'last_login'            => null,
            'is_valid'              => 1,
        ]);

        // 🔹 Charger les photos
        $photos = Storage::disk('public')->allFiles('profile-photos');
        if (empty($photos)) {
            dd("Aucune photo trouvée dans : " . storage_path('app/public/profile-photos'));
        }

        // 🔹 Listes de données
        $firstnames = ['Alex', 'Sarah', 'Marc', 'Isabelle', 'Kevin', 'Laura', 'David', 'Chantal', 'Eric', 'Mireille', 'Hugo', 'Fabienne', 'Louis', 'Arielle', 'Thomas'];
        $lastnames = ['Adjaho', 'Kpoton', 'Gandonou', 'Dossou', 'Mensah', 'Ketema', 'Houngbe', 'Assogba', 'Zinsou', 'Tokoudagba', 'Avlessi', 'Ayihoun', 'Dagba', 'Anato', 'Gbèdonou'];
        $cities = ['Cotonou', 'Porto-Novo', 'Abomey-Calavi', 'Bohicon', 'Ouidah'];
        $subjects_list = [
            ['Maths', 'Physics'],
            ['English', 'French'],
            ['Computer Science'],
            ['Biology', 'Chemistry'],
            ['History', 'Geography'],
            ['Philosophy'],
            ['Economics', 'Management']
        ];
        $learning_pref = ['online', 'in_person', 'hybrid'];

        // 🔹 Génération de 15 professeurs aléatoires
        for ($i = 0; $i < 15; $i++) {
            $firstname = $firstnames[array_rand($firstnames)];
            $lastname = $lastnames[array_rand($lastnames)];

            User::create([
                'firstname'             => $firstname,
                'lastname'              => $lastname,
                'email'                 => strtolower($firstname) . "." . strtolower($lastname) . $i . '@example.com',
                'email_verified_at'     => now(),
                'password'              => Hash::make('password123'),
                'telephone'             => '+229' . rand(90000000, 99999999),
                'photo_path'            => 'profile-photos/' . basename($photos[array_rand($photos)]),
                'role_id'               => 3,
                'is_active'             => 1,
                'remember_token'        => Str::random(10),
                'created_at'            => now(),
                'updated_at'            => now(),
                'bio'                   => null,
                'qualifications'        => null,
                'subjects'              => json_encode($subjects_list[array_rand($subjects_list)]),
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
        }
    }
}
