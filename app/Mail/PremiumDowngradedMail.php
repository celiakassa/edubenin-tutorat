<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class PremiumDowngradedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user, public string $renewalUrl) {}

    public function build(): self
    {
        return $this->subject('Votre offre Premium a expiré – retour à l\'offre Standard')
            ->view('emails.premium-downgraded');
    }
}
