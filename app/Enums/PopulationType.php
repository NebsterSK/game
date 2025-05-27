<?php

namespace App\Enums;

enum PopulationType : string
{
    case Builder = 'builder';
    case Engineer = 'engineer';
    case Scientist = 'scientist';
}