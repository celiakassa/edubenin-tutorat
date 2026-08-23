<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

final class SendWelcomeEmailAfterVerification
{
    public function handle(Verified $event): void
    {
        $user = $event->user;

        $sent = $user->newQuery()
            ->whereKey($user->getKey())
            ->whereNull('welcome_email_sent_at')
            ->update(['welcome_email_sent_at' => now()]);

        if ($sent === 0) {
            return;
        }

        Mail::to($user->email)->send(new WelcomeMail($user));
    }
}
