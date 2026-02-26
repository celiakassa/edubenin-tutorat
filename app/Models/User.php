<?php

namespace App\Models;

use App\LearningPreference;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'telephone',
        'photo_path',
        'birthdate',
        'remember_token',
        'bio',
        'qualifications',
        'subjects',
        'rate_per_hour',
        'availability',
        'city',
        'is_active',
        'learning_history',
        'learning_preference',
        'satisfaction_score',
        'notify_email',
        'notify_push',
        'role_id',
        'last_login',
        'is_valid',
        'identity_verified',
        'identity_document_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'student_id');
    }

    // ← Relation corrigée
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // ← Méthode corrigée
    public function subscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('statut', 'active')
            ->latest('date_fin');
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('statut', 'active')
            ->where('date_fin', '>', now());
    }

    public function isSubscribed()
    {
        $sub = $this->activeSubscription;
        return $sub && $sub->date_fin && $sub->date_fin->isFuture();
    }

    // Méthodes de rôle
    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isEtudiant()
    {
        return $this->role_id === 2;
    }

    public function isTuteur()
    {
        return $this->role_id === 3;
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login' => 'datetime',
            'learning_preference' => LearningPreference::class,
        ];
    }
}
