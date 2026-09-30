<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class PremiumExpiringMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user, public Subscription $subscription, public string $renewalUrl, public bool $isLastDay = false) {}

    public function build(): self
    {
        return $this->subject($this->isLastDay ? 'Dernier jour de votre offre Premium' : 'Votre offre Premium se termine bientôt')
            ->view('emails.premium-expiring');
    }
}
