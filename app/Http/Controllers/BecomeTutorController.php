<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

final class BecomeTutorController extends Controller
{
    public function index(): Factory|View
    {
        $recentTutors = User::with('subjects')
            ->where('role_id', 3)
            ->where('is_active', 1)
            ->where('is_valid', 1)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('pages.devenir-tuteur', [
            'recentTutors' => $recentTutors,
            'stats' => $this->gatherStats(),
        ]);
    }

    /**
     * Chiffres cles de la plateforme, recuperes en un seul aller-retour base
     * de donnees (sous-requetes scalaires) plutot que plusieurs requetes
     * dispersees.
     */
    private function gatherStats(): array
    {
        $row = DB::selectOne(<<<'SQL'
            SELECT
                (SELECT COUNT(*) FROM users WHERE role_id = 3 AND is_active = 1 AND is_valid = 1) AS tutors_count,
                (SELECT COUNT(*) FROM subjects WHERE is_active = 1) AS subjects_count,
                (SELECT COUNT(*) FROM annonces WHERE status = 'attribuee') AS missions_count
            SQL);

        return [
            'tutorsCount' => (int) $row->tutors_count,
            'subjectsCount' => (int) $row->subjects_count,
            'missionsCount' => (int) $row->missions_count,
        ];
    }
}
