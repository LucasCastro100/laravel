<?php

namespace App\Enums;

enum EquipmentCondition: string
{
    case Novo = 'novo';
    case Seminovo = 'seminovo';
    case Usado = 'usado';
    case ParaPecas = 'para_pecas';

    public function label(): string
    {
        return match ($this) {
            self::Novo => 'Novo',
            self::Seminovo => 'Seminovo',
            self::Usado => 'Usado',
            self::ParaPecas => 'Para peças',
        };
    }
}
