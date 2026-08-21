<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class BecomeTutorController extends Controller
{
    public function index(): Factory|View
    {
        $recentTutors = User::where('role_id', 3)
            ->where('is_active', 1)
            ->where('is_valid', 1)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('pages.devenir-tuteur', ['recentTutors' => $recentTutors]);
    }
}
