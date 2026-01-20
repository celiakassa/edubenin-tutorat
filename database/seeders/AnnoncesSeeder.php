<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AnnoncesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('annonces')->insert([
            [
                'title' => 'Cours de Mathématiques',
                'description' => 'Cours de soutien en mathématiques pour lycéens.',
                'student_id' => 26,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Aide en Physique',
                'description' => 'Besoin d’aide pour les exercices de physique.',
                'student_id' => 26,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Cours d’Anglais',
                'description' => 'Recherche professeur pour améliorer mon anglais oral.',
                'student_id' => 26,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Soutien Informatique',
                'description' => 'Aide pour apprendre la programmation Python.',
                'student_id' => 26,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
