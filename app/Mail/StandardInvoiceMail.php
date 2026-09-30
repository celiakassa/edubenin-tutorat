<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class StandardInvoiceMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user, public int $amount, public string $checkoutUrl) {}

    public function build(): self
    {
        return $this->subject('Votre facture mensuelle Kopiao')
            ->view('emails.standard-invoice');
    }
}
