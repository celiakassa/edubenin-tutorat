<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class CandidatureAcceptee extends Mailable
{
    use Queueable;

    use SerializesModels;

    public $annonce;

    public $etudiant;

    public $tuteur;

    public function __construct(public Candidature $candidature)
    {
        $this->annonce = $this->candidature->annonce;
        $this->etudiant = $this->candidature->annonce->student;
        $this->tuteur = $this->candidature->tuteur;
    }

    public function build()
    {
        return $this->subject('🎉 Félicitations ! Votre candidature a été acceptée - Kopiao')
            ->view('emails.candidature-acceptee')
            ->with([
                'candidature' => $this->candidature,
                'annonce' => $this->annonce,
                'etudiant' => $this->etudiant,
                'tuteur' => $this->tuteur,
            ]);
    }
}
