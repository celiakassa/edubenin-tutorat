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

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'learning_preference' => LearningPreference::class,
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'student_id');
    }

    // 🔐 Méthodes de rôle
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

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


    public function activeSubscription()
    {
        // On utilise 'statut' car c'est le nom dans ton modèle Subscription
        return $this->hasOne(Subscription::class)->where('statut', 'active');
    }

    public function isSubscribed()
    {
        $sub = $this->activeSubscription;
        // Vérifie si la sub existe ET si la date de fin est dans le futur
        return $sub && $sub->date_fin && $sub->date_fin->isFuture();
    }



}
