<?php

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidatureRefusee extends Mailable
{
    use Queueable, SerializesModels;

    public $candidature;
    public $annonce;
    public $tuteur;

    public function __construct(Candidature $candidature)
    {
        $this->candidature = $candidature;
        $this->annonce = $candidature->annonce;
        $this->tuteur = $candidature->tuteur;
    }

    public function build()
    {
        return $this->subject('📝 Mise à jour de votre candidature - Kopiao')
                    ->view('emails.candidature-refusee')
                    ->with([
                        'candidature' => $this->candidature,
                        'annonce' => $this->annonce,
                        'tuteur' => $this->tuteur,
                    ]);
    }
}