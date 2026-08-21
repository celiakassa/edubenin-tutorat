<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final class LiaGeminiService
{
    private const ENDPOINT = 'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s';

    /**
     * Modeles gratuits, essayes dans l'ordre si l'un est en erreur ou a quota depasse.
     * gemini-2.0-flash et gemini-2.0-flash-lite ont ete retires par Google (404
     * "no longer available") ; gemini-3.5-flash-lite / -flash sont les equivalents
     * actuellement disponibles sur le niveau gratuit.
     */
    private const MODELS = ['gemini-3.5-flash-lite', 'gemini-3.5-flash'];

    private readonly ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    public function isAvailable(): bool
    {
        return filled($this->apiKey);
    }

    /**
     * Retourne la reponse de Gemini, ou null si aucun modele n'a pu repondre
     * (cle absente, quota epuise, erreur reseau...). Le controleur bascule
     * alors sur le service de repli.
     */
    public function reply(string $message, array $history, string $systemPrompt): ?string
    {
        if (! $this->isAvailable()) {
            return null;
        }

        $contents = $this->buildContents($history, $message);

        foreach (self::MODELS as $model) {
            $text = $this->callModel($model, $systemPrompt, $contents);
            if ($text !== null) {
                return $text;
            }
        }

        return null;
    }

    private function callModel(string $model, string $systemPrompt, array $contents): ?string
    {
        $url = sprintf(self::ENDPOINT, $model, $this->apiKey);

        try {
            $response = Http::timeout(20)->post($url, [
                'system_instruction' => ['parts' => [['text' => $systemPrompt]]],
                'contents' => $contents,
                'generationConfig' => $this->generationConfig($model),
            ]);
        } catch (Throwable $e) {
            Log::warning('Lia: appel Gemini impossible', ['model' => $model, 'error' => $e->getMessage()]);

            return null;
        }

        if ($response->status() === 429) {
            Log::warning('Lia: quota Gemini depasse', ['model' => $model]);

            return null;
        }

        if (! $response->successful()) {
            Log::warning('Lia: reponse Gemini en erreur', ['model' => $model, 'status' => $response->status()]);

            return null;
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

        return filled($text) ? trim((string) $text) : null;
    }

    /**
     * Les variantes "flash" pleines utilisent un budget de reflexion interne qui,
     * sans thinkingConfig, peut consommer tout maxOutputTokens sans produire de
     * texte (reponse vide, finishReason MAX_TOKENS). Les variantes "flash-lite"
     * n'exposent pas ce parametre : l'envoyer provoque une erreur 400.
     */
    private function generationConfig(string $model): array
    {
        $config = [
            'temperature' => 0.7,
            'maxOutputTokens' => 512,
        ];

        if (! str_contains($model, 'lite')) {
            $config['thinkingConfig'] = ['thinkingBudget' => 0];
        }

        return $config;
    }

    private function buildContents(array $history, string $message): array
    {
        $contents = [];

        foreach (array_slice($history, -10) as $turn) {
            if (! isset($turn['role'], $turn['content']) || $turn['content'] === '') {
                continue;
            }

            $contents[] = [
                'role' => $turn['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => (string) $turn['content']]],
            ];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $message]]];

        return $contents;
    }
}
