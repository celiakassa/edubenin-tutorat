<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'date_debut',
        'date_fin',
        'statut',
        'type_abonnement',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'datetime',
            'date_fin' => 'datetime',
        ];
    }

    /**
     * Relation avec l'utilisateur abonné
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les paiements
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
