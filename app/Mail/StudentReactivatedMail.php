<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentReactivatedMail extends Mailable
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
        return $this->subject('Votre compte a été réactivé')
                    ->view('emails.student-reactivated')
                    ->with([
                        'user' => $this->user,
                        'reason' => $this->reason
                    ]);
    }
}
