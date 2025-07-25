<?php

namespace App\Enums;

enum SituationMessage: int
{    
    case URGENTE = 2;
    case ALERTA = 1;
    case COMUM = 0;

    public function label(): string
    {
        return match ($this) {
            self::COMUM => 'success',
            self::ALERTA => 'warning',
            self::URGENTE => 'erro',
        };
    }
}
