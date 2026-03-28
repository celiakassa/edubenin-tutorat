<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Subject;
use Illuminate\Database\Seeder;

final class AnnoncesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentId = 17;

        // Récupérer quelques matières
        $subjects = Subject::whereIn('nom', [
            'Mathématiques',
            'Physique',
            'Français',
            'Anglais',
            'Programmation',
            'Économie',
            'Chimie',
            'Histoire',
            'Philosophie',
            'Comptabilité',
        ])->get();

        if ($subjects->isEmpty()) {
            $this->command->warn('Aucune matière trouvée. Veuillez exécuter SubjectsSeeder d\'abord.');

            return;
        }

        $annonces = [
            [
                'subject_id' => $subjects->where('nom', 'Mathématiques')->first()->id ?? $subjects->first()->id,
                'description' => 'Je cherche un tuteur en mathématiques pour m\'aider à préparer mon examen de terminale. J\'ai besoin d\'une aide particulière en analyse et en probabilités. Je souhaite des cours réguliers et un suivi personnalisé.',
                'budget' => 50000,
                'disponibilite' => "Lundi 14:00 - 16:00\nMercredi 16:00 - 18:00\nSamedi 09:00 - 12:00",
                'format' => 'presentiel',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'subject_id' => $subjects->where('nom', 'Physique')->first()->id ?? $subjects->first()->id,
                'description' => 'Besoin d\'un professeur de physique pour renforcer mes connaissances en électricité et magnétisme. Préparation aux examens universitaires. Niveau licence 2.',
                'budget' => 45000,
                'disponibilite' => "Mardi 18:00 - 20:00\nJeudi 18:00 - 20:00\nDimanche 10:00 - 12:00",
                'format' => 'en_ligne',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'subject_id' => $subjects->where('nom', 'Français')->first()->id ?? $subjects->first()->id,
                'description' => 'Recherche professeur de français pour améliorer mon niveau en rédaction et en analyse littéraire. Préparation au baccalauréat. Je souhaite travailler sur des textes du programme.',
                'budget' => 35000,
                'disponibilite' => "Lundi 16:00 - 18:00\nVendredi 14:00 - 16:00",
                'format' => 'hybrid',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'subject_id' => $subjects->where('nom', 'Anglais')->first()->id ?? $subjects->first()->id,
                'description' => 'Je prépare le TOEFL et j\'ai besoin d\'un tuteur natif ou bilingue pour m\'aider à améliorer mon score. Focus sur la partie speaking et writing.',
                'budget' => 60000,
                'disponibilite' => "Mardi 15:00 - 17:00\nJeudi 15:00 - 17:00\nSamedi 14:00 - 16:00",
                'format' => 'en_ligne',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'subject_id' => $subjects->where('nom', 'Programmation')->first()->id ?? $subjects->first()->id,
                'description' => 'Étudiant en informatique cherche tuteur pour apprendre Python et les bases de la data science. Débutant complet, besoin de cours progressifs et pratiques.',
                'budget' => 70000,
                'disponibilite' => "Mercredi 18:00 - 20:00\nSamedi 10:00 - 13:00",
                'format' => 'en_ligne',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'subject_id' => $subjects->where('nom', 'Économie')->first()->id ?? $subjects->first()->id,
                'description' => 'Besoin d\'aide en microéconomie et macroéconomie pour préparer mes partiels de licence. Cours intensifs souhaités sur 2 semaines.',
                'budget' => 40000,
                'disponibilite' => "Lundi 10:00 - 12:00\nMardi 10:00 - 12:00\nJeudi 10:00 - 12:00",
                'format' => 'presentiel',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'subject_id' => $subjects->where('nom', 'Chimie')->first()->id ?? $subjects->first()->id,
                'description' => 'Recherche tuteur en chimie organique pour m\'aider avec les réactions chimiques et la nomenclature. Niveau terminale scientifique.',
                'budget' => 38000,
                'disponibilite' => "Mercredi 14:00 - 16:00\nVendredi 16:00 - 18:00",
                'format' => 'presentiel',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(6),
            ],
            [
                'subject_id' => $subjects->where('nom', 'Histoire')->first()->id ?? $subjects->first()->id,
                'description' => 'Préparation au bac d\'histoire-géo. Besoin d\'aide pour la méthodologie de la dissertation et du commentaire de documents historiques.',
                'budget' => 30000,
                'disponibilite' => "Samedi 15:00 - 17:00\nDimanche 15:00 - 17:00",
                'format' => 'hybrid',
                'status' => 'en_attente',
                'is_paid' => false,
                'published_at' => null,
            ],
            [
                'subject_id' => $subjects->where('nom', 'Philosophie')->first()->id ?? $subjects->first()->id,
                'description' => 'Lycéen en terminale littéraire cherche professeur de philosophie pour préparer le bac. Besoin d\'aide pour comprendre les grands courants philosophiques.',
                'budget' => 32000,
                'disponibilite' => "Jeudi 16:00 - 18:00\nSamedi 09:00 - 11:00",
                'format' => 'presentiel',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(8),
            ],
            [
                'subject_id' => $subjects->where('nom', 'Comptabilité')->first()->id ?? $subjects->first()->id,
                'description' => 'Étudiant en BTS comptabilité cherche aide pour la comptabilité générale et analytique. Préparation aux examens de fin d\'année.',
                'budget' => 55000,
                'disponibilite' => "Lundi 17:00 - 19:00\nMercredi 17:00 - 19:00\nVendredi 17:00 - 19:00",
                'format' => 'en_ligne',
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($annonces as $annonceData) {
            $annonce = new Annonce();
            $annonce->student_id = $studentId;
            $annonce->subject_id = $annonceData['subject_id'];
            $annonce->description = $annonceData['description'];
            $annonce->budget = $annonceData['budget'];
            $annonce->acompte = $annonceData['budget'] * 0.3; // Calcul automatique de l'acompte à 30%
            $annonce->disponibilite = $annonceData['disponibilite'];
            $annonce->format = $annonceData['format'];
            $annonce->status = $annonceData['status'];
            $annonce->is_paid = $annonceData['is_paid'];
            $annonce->published_at = $annonceData['published_at'];
            $annonce->save();
        }

        $this->command->info('✅ '.count($annonces).' annonces créées pour le student_id '.$studentId);
    }
}
