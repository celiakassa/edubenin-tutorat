<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'welcome_email_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'welcome_email_sent_at' => 'datetime',
        ];
    }
}
