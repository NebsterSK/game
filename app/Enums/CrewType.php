<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum CrewType: string
{
    case Builder = 'builder';
    case Engineer = 'engineer';
    case Scientist = 'scientist';

    public function toUpperCase(): string
    {
        return Str::upper($this->value);
    }
}
