<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class SubjectsSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Sciences exactes
            ['nom' => 'Mathématiques', 'description' => 'Algèbre, géométrie, analyse, statistiques'],
            ['nom' => 'Physique', 'description' => 'Mécanique, électricité, thermodynamique, optique'],
            ['nom' => 'Chimie', 'description' => 'Chimie organique, chimie inorganique, chimie analytique'],
            ['nom' => 'SVT', 'description' => 'Sciences de la vie et de la Terre, biologie, géologie'],
            ['nom' => 'Biologie', 'description' => 'Biologie cellulaire, génétique, écologie'],

            // Langues
            ['nom' => 'Français', 'description' => 'Grammaire, conjugaison, littérature, rédaction'],
            ['nom' => 'Anglais', 'description' => 'Grammaire, conversation, préparation TOEFL/IELTS'],
            ['nom' => 'Espagnol', 'description' => 'Grammaire, conversation, littérature espagnole'],
            ['nom' => 'Allemand', 'description' => 'Grammaire, conversation, culture germanique'],
            ['nom' => 'Italien', 'description' => 'Grammaire, conversation, culture italienne'],
            ['nom' => 'Arabe', 'description' => 'Arabe littéraire, dialectal, conversation'],
            ['nom' => 'Chinois', 'description' => 'Mandarin, écriture, conversation'],

            // Sciences humaines
            ['nom' => 'Histoire', 'description' => 'Histoire ancienne, moderne, contemporaine'],
            ['nom' => 'Géographie', 'description' => 'Géographie physique, humaine, économique'],
            ['nom' => 'Philosophie', 'description' => 'Philosophie antique, moderne, contemporaine'],
            ['nom' => 'Psychologie', 'description' => 'Psychologie générale, sociale, clinique'],
            ['nom' => 'Sociologie', 'description' => 'Théories sociologiques, méthodes d\'enquête'],

            // Économie et gestion
            ['nom' => 'Économie', 'description' => 'Microéconomie, macroéconomie, économie internationale'],
            ['nom' => 'Gestion', 'description' => 'Management, ressources humaines, stratégie'],
            ['nom' => 'Comptabilité', 'description' => 'Comptabilité générale, analytique, financière'],
            ['nom' => 'Marketing', 'description' => 'Marketing fondamental, digital, études de marché'],
            ['nom' => 'Finance', 'description' => 'Finance d\'entreprise, marchés financiers'],

            // Informatique
            ['nom' => 'Programmation', 'description' => 'Python, Java, PHP, JavaScript, C++'],
            ['nom' => 'Web Design', 'description' => 'HTML, CSS, UI/UX design, frameworks'],
            ['nom' => 'Bureautique', 'description' => 'Excel, Word, PowerPoint, Access'],
            ['nom' => 'Base de données', 'description' => 'SQL, MySQL, PostgreSQL, MongoDB'],
            ['nom' => 'Réseaux', 'description' => 'CCNA, administration réseau, sécurité'],

            // Arts
            ['nom' => 'Musique', 'description' => 'Solfège, instrument, théorie musicale'],
            ['nom' => 'Arts plastiques', 'description' => 'Dessin, peinture, sculpture'],
            ['nom' => 'Théâtre', 'description' => 'Expression dramatique, improvisation'],
            ['nom' => 'Danse', 'description' => 'Danse classique, moderne, contemporaine'],

            // Droit
            ['nom' => 'Droit civil', 'description' => 'Droit des personnes, de la famille, des biens'],
            ['nom' => 'Droit pénal', 'description' => 'Droit pénal général, procédure pénale'],
            ['nom' => 'Droit des affaires', 'description' => 'Droit des sociétés, commercial'],

            // Préparation concours
            ['nom' => 'Préparation concours', 'description' => 'Concours administratifs, grandes écoles'],
            ['nom' => 'Aide aux devoirs', 'description' => 'Soutien scolaire tous niveaux'],
            ['nom' => 'Méthodologie', 'description' => 'Organisation, prise de notes, révision'],
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert([
                'nom' => $subject['nom'],
                'description' => $subject['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
