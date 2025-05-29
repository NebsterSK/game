<?php

namespace App\Enums;

enum AssetType : string
{
    case Building = 'building';
    case Technology = 'technology';
    case Research = 'research';
}