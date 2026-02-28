<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;

class RechercheController extends Controller
{
    public function rechercher(Request $request)
    {
        $subject = $request->subject;
        $city = $request->city;
        $learning = $request->learning_preference;

        // Query de base : uniquement professeurs ACTIFS et VALIDÉS
        $query = User::where('role_id', 3)  // role_id = 3 pour les professeurs
                      ->where('is_active', 1)  // Compte actif
                      ->where('is_valid', 1);  // Ajout de la validation des professeurs

        // Filtre par matière (avec la table pivot)
        if (!empty($subject)) {
            $subjectId = Subject::where('nom', $subject)->value('id');
            if ($subjectId) {
                $query->whereHas('subjects', function($q) use ($subjectId) {
                    $q->where('subject_id', $subjectId);
                });
            }
        }

        // Filtre par ville (recherche insensible à la casse)
        if (!empty($city)) {
            $query->where(function($q) use ($city) {
                $q->where('city', 'LIKE', '%' . $city . '%')
                  ->orWhere('city', 'LIKE', '%' . ucfirst(strtolower($city)) . '%');
            });
        }

        // Filtre par préférence d'apprentissage
        if (!empty($learning)) {
            if ($learning == 'both') {
                $query->whereIn('learning_preference', ['online', 'in_person']);
            } else {
                $query->where('learning_preference', $learning);
            }
        }

        // Tri par ordre décroissant de satisfaction ou date de création
        $query->orderBy('satisfaction_score', 'DESC')
              ->orderBy('created_at', 'DESC');

        // Résultats finaux avec pagination
        $tuteurs = $query->paginate(12);

        // Récupérer les matières populaires (depuis la table subjects)
        $matieresPopulaires = Subject::where('is_active', true)
            ->orderBy('nom')
            ->pluck('nom')
            ->take(40)
            ->sort()
            ->values()
            ->all();

        // Récupérer les villes populaires (uniquement des professeurs validés)
        $villesPopulaires = User::where('role_id', 3)
            ->where('is_active', 1)
            ->where('is_valid', 1)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->pluck('city')
            ->map(fn($city) => trim($city))
            ->filter()
            ->unique()
            ->take(30)
            ->values()
            ->sort()
            ->all();

        return view('recherche.resultats', [
            'tuteurs' => $tuteurs,
            'matieresPopulaires' => $matieresPopulaires,
            'villesPopulaires' => $villesPopulaires,
            'subject' => $subject,
            'city' => $city,
            'learning' => $learning
        ]);
    }
}
