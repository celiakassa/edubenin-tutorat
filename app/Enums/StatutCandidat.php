<?php

namespace App\Enums;

enum StatutCandidat: string
{
    case EN_ATTENTE = 'en_attente';
    case VALIDE = 'valide';
    case REFUSE = 'refuse';
}
