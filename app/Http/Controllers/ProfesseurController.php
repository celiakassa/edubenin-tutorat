<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    /**
     * Afficher la liste des professeurs
     */
    public function index()
    {
        // Récupérer les utilisateurs avec role_id = 3 (professeurs) et is_active = 1
        $professeurs = User::where('role_id', 3)
                          ->where('is_active', 1)
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);

        return view('recherche.index', compact('professeurs'));
    }
}
