<?php

namespace App\Enums;

enum DisputeStatus: string
{
    case Open = 'open';
    case Resolved = 'resolved';
    case Dismissed = 'dismissed';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Aberta',
            self::Resolved => 'Resolvida',
            self::Dismissed => 'Arquivada',
        };
    }
}
