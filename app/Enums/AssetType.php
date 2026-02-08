<?php

namespace App\Enums;

enum AssetType: string
{
    case Building = 'building';
    case Technology = 'technology';
    case Research = 'research';

    public function toCrewType(): CrewType
    {
        return match ($this) {
            self::Building => CrewType::Builder,
            self::Technology => CrewType::Engineer,
            self::Research => CrewType::Scientist,
        };
    }

    public function toVerb(): string
    {
        return match ($this) {
            self::Building => 'build',
            self::Technology => 'develop',
            self::Research => 'research',
        };
    }
}
