<?php

namespace App\Enums;

enum PermutaTipo: string
{
    case Ganho = 'ganho';
    case Despesa = 'despesa';

    /**
     * Whether this permuta represents income ("ganho") for the creator.
     */
    public function isGanho(): bool
    {
        return $this === self::Ganho;
    }

    /**
     * Whether this permuta represents an expense ("despesa") for the creator.
     */
    public function isDespesa(): bool
    {
        return $this === self::Despesa;
    }
}
