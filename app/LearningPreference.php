<?php

declare(strict_types=1);

namespace App;

enum LearningPreference: string
{
    case IN_PERSON = 'in_person';
    case ONLINE = 'online';
    case HYBRID = 'hybrid';
}
