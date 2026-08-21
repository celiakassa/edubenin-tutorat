<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final class LiaGeminiService
{
    private const ENDPOINT = 'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s';

    /** Modeles gratuits, essayes dans l'ordre si l'un est en erreur ou a quota depasse. */
    private const MODELS = ['gemini-2.0-flash', 'gemini-2.0-flash-lite'];

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
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 512,
                ],
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
