<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $teacher;
    public $reason;

    public function __construct(User $teacher, $reason = '')
    {
        $this->teacher = $teacher;
        $this->reason = $reason;
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
