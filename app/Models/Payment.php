<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'user_id',
        'fedapay_transaction_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'payment_details',
        'subscription_id',
        'paid_at',
        'moneroo_payment_id'
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'abonnement
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    // Scopes
    protected function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    protected function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    protected function casts(): array
    {
        return [
            'payment_details' => 'array',
            'amount' => 'decimal:2',
            'paid_at' => 'datetime'
        ];
    }
}
