<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;

final class ProfesseurController extends Controller
{
    /**
     * Afficher la liste des professeurs
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Récupérer les professeurs actifs et validés
        $professeurs = User::where('role_id', 3)
            ->where('is_active', 1)
            ->where('is_valid', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Total des tuteurs experts
        $totalExperts = $professeurs->total();

        return view('recherche.index', ['professeurs' => $professeurs, 'totalExperts' => $totalExperts]);
    }
}
