<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        // Filtre par matière (avec JSON ou tableau)
        if (!empty($subject)) {
            $query->where(function($q) use ($subject) {
                $q->where('subjects', 'LIKE', '%"' . $subject . '"%')  // Pour les JSON
                  ->orWhere('subjects', 'LIKE', '%' . $subject . '%'); // Pour les chaînes simples
            });
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

        // Récupérer les matières populaires (uniquement des professeurs validés)
        $matieresPopulaires = User::where('role_id', 3)
            ->where('is_active', 1)
            ->where('is_valid', 1)  // Ajout de la validation
            ->whereNotNull('subjects')
            ->where('subjects', '!=', '[]')
            ->pluck('subjects')
            ->flatMap(function ($subjects) {
                // Gérer à la fois les JSON et les chaînes simples
                if (is_array($subjects) || is_string($subjects)) {
                    if (is_string($subjects)) {
                        // Essayer de décoder le JSON
                        $decoded = json_decode($subjects, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            return $decoded;
                        }
                        // Sinon, traiter comme une chaîne séparée par des virgules
                        return array_map('trim', explode(',', $subjects));
                    }
                    return $subjects;
                }
                return [];
            })
            ->filter(function ($subject) {
                // Filtrer les valeurs vides et les sujets non pertinents
                return !empty($subject) && $subject !== '[]' && $subject !== 'null';
            })
            ->unique()
            ->values()
            ->take(40)
            ->sort()
            ->all();

        // Récupérer les villes populaires (uniquement des professeurs validés)
        $villesPopulaires = User::where('role_id', 3)
            ->where('is_active', 1)
            ->where('is_valid', 1)  // Ajout de la validation
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

        return view('recherche.resultats', compact(
            'tuteurs',
            'matieresPopulaires',
            'villesPopulaires',
            'subject',
            'city',
            'learning'
        ));
    }
}
