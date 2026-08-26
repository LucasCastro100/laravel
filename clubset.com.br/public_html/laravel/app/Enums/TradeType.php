<?php

namespace App\Enums;

enum TradeType: string
{
    case PermutaDireta = 'permuta_direta';
    case Credito = 'credito';
    case Venda = 'venda';

    public function label(): string
    {
        return match ($this) {
            self::PermutaDireta => 'Permuta direta',
            self::Credito => 'Permuta por crédito',
            self::Venda => 'Venda',
        };
    }

    /**
     * Trade types that require a negotiated price.
     *
     * @return array<int, self>
     */
    public static function priced(): array
    {
        return [self::Credito, self::Venda];
    }
}
