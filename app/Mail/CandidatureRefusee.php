<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class CandidatureRefusee extends Mailable
{
    use Queueable;

    use SerializesModels;

    public $annonce;

    public $tuteur;

    public function __construct(public Candidature $candidature)
    {
        $this->annonce = $this->candidature->annonce;
        $this->tuteur = $this->candidature->tuteur;
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
