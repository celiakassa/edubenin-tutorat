<?php

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidatureAcceptee extends Mailable
{
    use Queueable, SerializesModels;

    public $candidature;
    public $annonce;
    public $etudiant;
    public $tuteur;

    public function __construct(Candidature $candidature)
    {
        $this->candidature = $candidature;
        $this->annonce = $candidature->annonce;
        $this->etudiant = $candidature->annonce->student;
        $this->tuteur = $candidature->tuteur;
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