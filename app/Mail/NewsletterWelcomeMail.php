<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class NewsletterWelcomeMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public string $email)
    {
    }

    public function build()
    {
        return $this->subject('Bienvenue dans la newsletter Kopiao')
            ->view('emails.newsletter-welcome')
            ->with(['email' => $this->email]);
    }
}
