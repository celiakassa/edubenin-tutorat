<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Annonce extends Model
{
    use HasFactory;
    use HasHashid;
    protected $fillable = [
        'student_id',
        'subject_id', // Changé de 'domaine' à 'subject_id'
        'description',
        'budget',
        'acompte',
        'status',
        'disponibilite',
        'format',
        'is_paid',
        'published_at',
        'payment_reference',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:2',
            'acompte' => 'decimal:2',
            'published_at' => 'datetime',
            'is_paid' => 'boolean',
        ];
    }

    /**
     * Relation avec l'étudiant (utilisateur)
     *
     * @return BelongsTo<User, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relation avec la matière (NOUVELLE)
     *
     * @return BelongsTo<Subject, $this>
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Relation avec les paiements
     *
     * @return HasMany<Payment, $this>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latest();
    }

    /**
     * Calcul automatique de l'acompte (30% fixe)
     */
    public function calculateAcompte(): float
    {
        $percentage = 0.3; // Fixé à 30%

        // Conversion explicite + arrondi pour éviter les overflow MySQL
        $budget = (float) $this->budget;

        $this->acompte = round($budget * $percentage, 2);

        return $this->acompte;
    }

    // Vérifier si le paiement est en cours
    public function isPaymentPending(): bool
    {
        return $this->status === 'en_paiement';
    }

    // Marquer l'annonce comme publiée
    public function markAsPublished(): void
    {
        $this->status = 'publiée';
        $this->is_paid = true;
        $this->published_at = now();
        $this->save();
    }

    /**
     * Relation avec les candidatures
     *
     * @return HasMany<Candidature, $this>
     */
    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }

    /**
     * Relation avec le tuteur accepté (via candidature)
     */
    public function tuteurAccepte()
    {
        return $this->hasOneThrough(
            User::class,
            Candidature::class,
            'annonce_id',
            'id',
            'id',
            'user_id'
        )->where('candidatures.statut', 'acceptee');
    }

    /**
     * Vérifie si l'annonce est attribuée
     */
    public function estAttribuee(): bool
    {
        return $this->candidatures()->where('statut', 'acceptee')->exists();
    }

    /**
     * Vérifie si l'annonce est publiée
     */
    public function estPubliee(): bool
    {
        return $this->status === 'publiée';
    }

    /**
     * Scope pour les annonces publiées
     */
    protected function scopePubliees($query)
    {
        return $query->where('status', 'publiée');
    }

    /**
     * Obtenir le tuteur accepté
     */
    protected function getTuteurAccepteAttribute()
    {
        $candidatureAcceptee = $this->candidatures()->where('statut', 'acceptee')->first();

        return $candidatureAcceptee ? $candidatureAcceptee->tuteur : null;
    }

    /**
     * Obtenir le nom de la matière (accesseur)
     */
    protected function domaine(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: 
            // Pour la rétrocompatibilité, si vous avez encore du code qui utilise $annonce->domaine
            fn() => $this->subject ? $this->subject->nom : null);
    }

    /**
     * Formatage disponibilité
     */
    protected function formattedDisponibilite(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: function (): string {
            if (empty($this->disponibilite)) {
                return 'Non spécifié';
            }

            $lines = explode("\n", mb_trim($this->disponibilite));
            $formatted = '';
            foreach ($lines as $line) {
                $line = mb_trim($line);
                if ($line !== '' && $line !== '0') {
                    $formatted .= '<li>'.e($line).'</li>';
                }
            }

            return $formatted !== '' && $formatted !== '0' ? '<ul class="list-unstyled mb-0">'.$formatted.'</ul>' : 'Non spécifié';
        });
    }
}
