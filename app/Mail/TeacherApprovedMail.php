<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class TeacherApprovedMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    public function __construct(public User $teacher, public $reason = '')
    {
    }

    public function build()
    {
        return $this->subject('Votre compte professeur a été approuvé - Kopiao')
            ->view('emails.teacher-approved')
            ->with([
                'teacher' => $this->teacher,
                'reason' => $this->reason,
            ]);
    }
}
