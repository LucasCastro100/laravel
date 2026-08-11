<?php

namespace App\Enums;

enum ListingType: string
{
    case Permuta = 'permuta';
    case Venda = 'venda';
    case Ambos = 'ambos';

    public function label(): string
    {
        return match ($this) {
            self::Permuta => 'Permuta',
            self::Venda => 'Venda',
            self::Ambos => 'Permuta ou venda',
        };
    }
}
