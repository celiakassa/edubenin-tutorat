<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class StudentDeactivatedMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    public function __construct(public $user, public $reason)
    {
    }

    public function build()
    {
        return $this->subject('Votre compte a été désactivé')
            ->view('emails.student-deactivated')
            ->with([
                'user' => $this->user,
                'reason' => $this->reason,
            ]);
    }
}
