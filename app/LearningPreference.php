<?php

namespace App;

enum LearningPreference: string
{
    case IN_PERSON = 'in_person';
    case ONLINE = 'online';
    case HYBRID = 'hybrid';
}
