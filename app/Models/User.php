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

    // Corrige le casts
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime', // <-- ajoute cette ligne
        'learning_preference' => LearningPreference::class,
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
