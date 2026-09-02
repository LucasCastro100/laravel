<?php

namespace App\Enums;

enum PermutaStatus: string
{
    case Pending = 'pendente';
    case Completed = 'concluida';
    case Cancelled = 'cancelada';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Completed => 'Concluída',
            self::Cancelled => 'Cancelada',
        };
    }
}
