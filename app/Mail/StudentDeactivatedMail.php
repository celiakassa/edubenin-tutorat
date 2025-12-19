<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentDeactivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reason;

    public function __construct($user, $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Votre compte a été désactivé')
                    ->view('emails.student-deactivated')
                    ->with([
                        'user' => $this->user,
                        'reason' => $this->reason
                    ]);
    }
}
