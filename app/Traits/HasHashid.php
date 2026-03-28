<?php

declare(strict_types=1);

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids;

/**
 * Trait HasHashid
 *
 * Permet d'ajouter facilement un identifiant hashé (hashid) à un modèle Eloquent
 * et de retrouver un modèle à partir de ce hashid.
 * Nécessite le package vinkla/hashids.
 */
trait HasHashid
{
    /**
     * Retrouve un modèle par son hashid ou échoue avec une 404.
     *
     * @param  string  $hash  Le hashid à décoder
     * @return static
     */
    public static function findByHashidOrFail($hash)
    {
        // Décode le hashid pour obtenir l'id original
        $decoded = Hashids::decode($hash);

        // Si le hashid est invalide ou ne correspond à aucun id
        abort_if(count($decoded) === 0, 404);

        // Recherche le modèle par l'id décodé
        return static::findOrFail($decoded[0]);
    }

    /**
     * Accesseur pour obtenir le hashid du modèle à partir de son id.
     * Utilisable comme $model->hashid
     *
     * @return string
     */
    protected function getHashidAttribute()
    {
        // Encode l'id du modèle en hashid unique
        return Hashids::encode($this->id);
    }
}
