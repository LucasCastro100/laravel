<?php

namespace App\Enums;

enum ListingIntent: string
{
    case Ofereco = 'ofereco';
    case Procuro = 'procuro';

    public function label(): string
    {
        return match ($this) {
            self::Ofereco => 'Ofereço',
            self::Procuro => 'Procuro',
        };
    }
}
