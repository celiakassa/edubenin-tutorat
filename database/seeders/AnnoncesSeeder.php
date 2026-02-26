<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AnnoncesSeeder extends Seeder
{
        public function run(): void
        {
            DB::table('annonces')->insert([
                [
                    'student_id' => 1,
                    'domaine' => 'Mathématiques',
                    'description' => 'Cours de soutien en mathématiques pour lycéens.',
                    'budget' => 50.00,
                    'acompte' => 10.00,
                    'status' => 'en_attente',
                    'disponibilite' => \Illuminate\Support\Facades\Date::now()->addDays(1),
                    'format' => 'presentiel',
                    'is_paid' => false,
                    'published_at' => \Illuminate\Support\Facades\Date::now(),
                    'payment_reference' => null,
                    'created_at' => \Illuminate\Support\Facades\Date::now(),
                    'updated_at' => \Illuminate\Support\Facades\Date::now(),
                ],
                [
                    'student_id' => 1,
                    'domaine' => 'Physique',
                    'description' => 'Besoin d’aide pour les exercices de physique.',
                    'budget' => 60.00,
                    'acompte' => 15.00,
                    'status' => 'en_attente',
                    'disponibilite' => \Illuminate\Support\Facades\Date::now()->addDays(2),
                    'format' => 'en_ligne',
                    'is_paid' => false,
                    'published_at' => \Illuminate\Support\Facades\Date::now(),
                    'payment_reference' => null,
                    'created_at' => \Illuminate\Support\Facades\Date::now(),
                    'updated_at' => \Illuminate\Support\Facades\Date::now(),
                ],
                [
                    'student_id' => 1,
                    'domaine' => 'Anglais',
                    'description' => 'Recherche professeur pour améliorer mon anglais oral.',
                    'budget' => 40.00,
                    'acompte' => 10.00,
                    'status' => 'en_attente',
                    'disponibilite' => \Illuminate\Support\Facades\Date::now()->addDays(3),
                    'format' => 'hybrid',
                    'is_paid' => false,
                    'published_at' => \Illuminate\Support\Facades\Date::now(),
                    'payment_reference' => null,
                    'created_at' => \Illuminate\Support\Facades\Date::now(),
                    'updated_at' => \Illuminate\Support\Facades\Date::now(),
                ],
                [
                    'student_id' => 1,
                    'domaine' => 'Informatique',
                    'description' => 'Aide pour apprendre la programmation Python.',
                    'budget' => 70.00,
                    'acompte' => 20.00,
                    'status' => 'en_attente',
                    'disponibilite' => \Illuminate\Support\Facades\Date::now()->addDays(4),
                    'format' => 'presentiel',
                    'is_paid' => false,
                    'published_at' => \Illuminate\Support\Facades\Date::now(),
                    'payment_reference' => null,
                    'created_at' => \Illuminate\Support\Facades\Date::now(),
                    'updated_at' => \Illuminate\Support\Facades\Date::now(),
                ],
            ]);
        }
}
