<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Candidature extends Model
{
    protected $fillable = [
        'annonce_id',
        'user_id',
        'statut', // en_attente, acceptee, refusee
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relation avec l'annonce
     *
     * @return BelongsTo<Annonce, $this>
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Relation avec le tuteur (user)
     *
     * @return BelongsTo<User, $this>
     */
    public function tuteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation avec l'étudiant via l'annonce
     */
    public function etudiant()
    {
        return $this->hasOneThrough(
            User::class,
            Annonce::class,
            'id', // Foreign key on Annonce table
            'id', // Foreign key on User table
            'annonce_id', // Local key on Candidature table
            'user_id' // Local key on Annonce table
        );
    }

    /**
     * Vérifie si la candidature est en attente
     */
    public function estEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    /**
     * Vérifie si la candidature est acceptée
     */
    public function estAcceptee(): bool
    {
        return $this->statut === 'acceptee';
    }

    /**
     * Vérifie si la candidature est refusée
     */
    public function estRefusee(): bool
    {
        return $this->statut === 'refusee';
    }

    /**
     * Scope pour les candidatures en attente
     */
    protected function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour les candidatures acceptées
     */
    protected function scopeAcceptees($query)
    {
        return $query->where('statut', 'acceptee');
    }

    /**
     * Scope pour les candidatures refusées
     */
    protected function scopeRefusees($query)
    {
        return $query->where('statut', 'refusee');
    }
}
