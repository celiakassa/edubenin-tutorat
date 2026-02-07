<?php

namespace App\Models;

use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Annonce extends Model
{
    use HasFactory, HasHashid;

    protected $fillable = [
        'student_id',
        'domaine',
        'description',
        'budget',
        'acompte',
        'status',
        'disponibilite',
        'format',
        'is_paid',
        'published_at',
        'payment_reference'
    ];

    protected $casts = [
       
        'budget' => 'decimal:2',
        'acompte' => 'decimal:2',
        'published_at' => 'datetime',
        'is_paid' => 'boolean'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latest();
    }

    /**
     * Calcul automatique de l'acompte (20% à 30%)
     * Sécurisé pour les gros montants
     */
    public function calculateAcompte()
    {
        $percentage = rand(20, 30) / 100;

        // Conversion explicite + arrondi pour éviter les overflow MySQL
        $budget = (float) $this->budget;

        $this->acompte = round($budget * $percentage, 2);

        return $this->acompte;
    }

    // Vérifier si le paiement est en cours
    public function isPaymentPending()
    {
        return $this->status === 'en_paiement';
    }

    // Marquer l'annonce comme publiée
    public function markAsPublished()
    {
        $this->status = 'publiée'; // CORRECTION : 'publiée' avec accent
        $this->is_paid = true;
        $this->published_at = now();
        $this->save();
    }

    /**
     * Relation avec les candidatures
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
     * Scope pour les annonces publiées
     */
    public function scopePubliees($query)
    {
        return $query->where('status', 'publiée'); // CORRECTION : 'publiée' avec accent
    }

    /**
     * Vérifie si l'annonce est attribuée
     */
    public function estAttribuee(): bool
    {
        return $this->candidatures()->where('statut', 'acceptee')->exists();
    }

    /**
     * Obtenir le tuteur accepté
     */
    public function getTuteurAccepteAttribute()
    {
        $candidatureAcceptee = $this->candidatures()->where('statut', 'acceptee')->first();
        return $candidatureAcceptee ? $candidatureAcceptee->tuteur : null;
    }

    /**
     * Vérifie si l'annonce est publiée
     */
    public function estPubliee(): bool
    {
        return $this->status === 'publiée'; // CORRECTION : 'publiée' avec accent
    }

    // Formatage disponiblite
public function getFormattedDisponibiliteAttribute()
{
    if (empty($this->disponibilite)) {
        return 'Non spécifié';
    }

    $lines = explode("\n", trim($this->disponibilite));
    $formatted = '';

    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line)) {
            $formatted .= '<li>' . e($line) . '</li>';
        }
    }

    return $formatted ? '<ul class="list-unstyled mb-0">' . $formatted . '</ul>' : 'Non spécifié';
}
}
