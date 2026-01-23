<?php

namespace App\Models;

use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory , HasHashid;

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
        'disponibilite' => 'datetime',
        'budget' => 'decimal:2',
        'acompte' => 'decimal:2',
        'published_at' => 'datetime',
        'is_paid' => 'boolean'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latest();
    }

    // Calcul automatique de l'acompte (20-30%)
    public function calculateAcompte()
    {
        $percentage = rand(20, 30) / 100;
        $this->acompte = $this->budget * $percentage;
        return $this->acompte;
    }

    // Méthode pour vérifier si le paiement est en cours
    public function isPaymentPending()
    {
        return $this->status === 'en_paiement';
    }

    // Méthode pour marquer comme publiée
    public function markAsPublished()
    {
        $this->status = 'publiee';
        $this->is_paid = true;
        $this->published_at = now();
        $this->save();
    }
}