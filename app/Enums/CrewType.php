<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum CrewType: string
{
    case Builder = 'builder';
    case Engineer = 'engineer';
    case Scientist = 'scientist';

    public function toUcFirst(): string
    {
        return Str::of($this->value)->ucfirst();
    }
}
