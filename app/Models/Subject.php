<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'icon',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'subject_user');
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }
}
