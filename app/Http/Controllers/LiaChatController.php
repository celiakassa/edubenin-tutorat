<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Subject;
use App\Models\User;
use App\Services\LiaFallbackService;
use App\Services\LiaGeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

final class LiaChatController extends Controller
{
    public function __construct(
        private readonly LiaGeminiService $gemini,
        private readonly LiaFallbackService $fallback,
    ) {
    }

    public function chat(Request $request): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:500'],
            'history' => ['nullable', 'array'],
        ]);

        $context = $this->gatherContext();
        $reply = null;

        try {
            $reply = $this->gemini->reply($data['message'], $data['history'] ?? [], $this->buildSystemPrompt($context));
        } catch (Throwable $e) {
            Log::error('Lia: erreur inattendue lors de l\'appel Gemini', ['error' => $e->getMessage()]);
        }

        $source = 'gemini';
        if ($reply === null) {
            $reply = $this->fallback->reply($data['message'], $context);
            $source = 'fallback';
        }

        return response()->json(['reply' => $reply, 'source' => $source]);
    }

    private function gatherContext(): array
    {
        return [
            'tutors_count' => User::where('role_id', 3)->where('is_active', 1)->where('is_valid', 1)->count(),
            'subjects' => Subject::where('is_active', true)->orderBy('nom')->pluck('nom')->all(),
            'annonces_count' => Annonce::count(),
        ];
    }

    private function buildSystemPrompt(array $context): string
    {
        $subjects = $context['subjects'] !== [] ? implode(', ', array_slice($context['subjects'], 0, 15)) : 'non renseignées';

        return <<<PROMPT
            Tu es Lia, l'assistante virtuelle de Kopiao, une plateforme beninoise de mise en relation entre eleves/etudiants et tuteurs pour des cours particuliers.

            Donnees actuelles de la plateforme :
            - Nombre de tuteurs actifs et valides : {$context['tutors_count']}
            - Nombre d'annonces publiees : {$context['annonces_count']}
            - Matieres disponibles : {$subjects}

            Fonctionnement general :
            - Un eleve publie une annonce avec son besoin et son budget, puis paie un acompte de 30% pour la rendre visible.
            - Les tuteurs abonnes peuvent postuler aux annonces correspondant a leurs matieres.
            - Pour devenir tuteur : creer un compte, completer son profil, puis attendre la validation de l'equipe Kopiao.

            Consignes :
            - Reponds toujours en francais, de maniere courte, claire et chaleureuse (quelques phrases maximum).
            - Utilise les donnees ci-dessus quand la question porte sur des chiffres ou des faits concernant la plateforme.
            - Si tu ne sais pas, invite la personne a consulter la page "Comment ca marche ?" ou a contacter le support.
            - N'invente jamais de donnees chiffrees qui ne sont pas fournies ci-dessus.
            PROMPT;
    }
}
