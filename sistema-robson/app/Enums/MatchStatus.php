<?php

namespace App\Enums;

enum MatchStatus: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Completed = 'completed';
    case Declined = 'declined';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Accepted => 'Aceito',
            self::Completed => 'Concluído',
            self::Declined => 'Recusado',
            self::Cancelled => 'Cancelado',
        };
    }
}
