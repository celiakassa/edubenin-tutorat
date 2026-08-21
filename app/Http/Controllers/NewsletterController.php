<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\NewsletterWelcomeMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class NewsletterController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $subscriber = NewsletterSubscriber::where('email', $data['email'])->first();

        if ($subscriber) {
            return response()->json([
                'message' => 'Cette adresse est déjà abonnée à la newsletter.',
            ]);
        }

        $subscriber = NewsletterSubscriber::create(['email' => $data['email']]);

        try {
            Mail::to($subscriber->email)->send(new NewsletterWelcomeMail($subscriber->email));
            $subscriber->update(['welcome_email_sent_at' => now()]);
        } catch (\Throwable $e) {
            Log::error('Echec envoi email de bienvenue newsletter', [
                'email' => $subscriber->email,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'message' => 'Merci ! Votre inscription à la newsletter est confirmée.',
        ], 201);
    }
}
