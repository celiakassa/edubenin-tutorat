<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Offres élèves / parents
|--------------------------------------------------------------------------
| Tout est modifiable ici : prix, nombre d'annonces, fonctionnalités.
| - standard : facturé en fin de mois (si le prix est > 0).
| - premium  : payé au début du mois (le 1er), renouvelé automatiquement.
| `max_annonces` = null signifie illimité.
*/
return [
    'currency' => 'XOF',

    // Valeurs par défaut : l'administrateur les modifie depuis l'espace admin (Abonnements).
    // Jour du mois (1-28) où les Premium sont renouvelés.
    'renewal_day' => 1,

    // Fonctionnalités activables par offre (clé => libellé affiché).
    'feature_labels' => [
        'priority_support' => 'Support prioritaire',
        'featured_annonces' => 'Annonces mises en avant',
    ],

    // Nombre de jours avant la fin du premium pour envoyer le mail de rappel.
    'reminder_days_before' => 5,

    'plans' => [
        'standard' => [
            'label' => 'Standard',
            'price' => 0,
            'max_annonces' => 3,
            'features' => [
                'priority_support' => false,
                'featured_annonces' => false,
            ],
        ],
        'premium' => [
            'label' => 'Premium',
            'price' => 5000,
            'max_annonces' => null,
            'features' => [
                'priority_support' => true,
                'featured_annonces' => true,
            ],
        ],
    ],
];
