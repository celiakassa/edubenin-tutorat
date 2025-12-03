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

        // Query de base : uniquement professeurs
        $query = User::where('role_id', 3)
                      ->where('is_active', 1);

        // Filtre par matière
        if (!empty($subject)) {
            $query->where('subjects', 'LIKE', '%' . $subject . '%');
        }

        // Filtre par ville
        if (!empty($city)) {
            $query->where('city', 'LIKE', '%' . $city . '%');
        }

        // Filtre par préférence d'apprentissage
        if (!empty($learning)) {
            if ($learning == 'both') {
                $query->whereIn('learning_preference', ['online', 'in_person']);
            } else {
                $query->where('learning_preference', $learning);
            }
        }

        // Résultats finaux avec pagination
        $tuteurs = $query->paginate(12);

        // Récupérer les matières populaires
        $matieresPopulaires = User::where('role_id', 3)
            ->where('is_active', 1)
            ->whereNotNull('subjects')
            ->pluck('subjects')
            ->flatMap(function ($subjects) {
                return explode(',', $subjects);
            })
            ->map(fn($subject) => trim($subject))
            ->filter()
            ->unique()
            ->take(40)
            ->values()
            ->all();

        // Récupérer les villes populaires
        $villesPopulaires = User::where('role_id', 3)
            ->where('is_active', 1)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->pluck('city')
            ->map(fn($city) => trim($city))
            ->filter()
            ->unique()
            ->take(30)
            ->values()
            ->all();

        return view('recherche.resultats', compact('tuteurs', 'matieresPopulaires', 'villesPopulaires', 'subject', 'city', 'learning'));
    }
}
