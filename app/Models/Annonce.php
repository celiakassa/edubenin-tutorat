<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

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
        'published_at'
    ];

    protected $casts = [
        'disponibilite' => 'datetime',
        'budget' => 'decimal:2',
        'acompte' => 'decimal:2',
        'published_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // Calcul automatique de l'acompte (20-30%)
    public function calculateAcompte()
    {
        $percentage = rand(20, 30) / 100;
        $this->acompte = $this->budget * $percentage;
        return $this->acompte;
    }
}