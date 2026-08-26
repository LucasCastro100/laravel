<?php

namespace App\Enums;

enum ListingStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Rejected = 'rejected';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Aguardando moderação',
            self::Active => 'Ativo',
            self::Rejected => 'Recusado',
            self::Archived => 'Arquivado',
        };
    }
}
