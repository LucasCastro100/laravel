<?php

namespace App\Enums;

enum RateType: string
{
    case Hora = 'hora';
    case Diaria = 'diaria';
    case Permuta = 'permuta';

    public function label(): string
    {
        return match ($this) {
            self::Hora => 'Por hora',
            self::Diaria => 'Por diária',
            self::Permuta => 'Permuta',
        };
    }
}
