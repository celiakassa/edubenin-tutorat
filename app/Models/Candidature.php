<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    protected $fillable = [
        'annonce_id',
        'user_id',
        'statut',
    ];

    /**
     * Relation avec l'annonce
     */
    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Relation avec le professeur (user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
