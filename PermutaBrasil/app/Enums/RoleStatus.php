<?php

namespace App\Enums;

enum RoleStatus: int
{    
    case ADMIN = 3;
    case ASSOCIADO_PRO = 2;
    case ASSOCIADO = 1;
    case USUÁRIO = 0;

    public function label(): string
    {
        return match ($this) {
            self::USUÁRIO => 'Usuário',
            self::ASSOCIADO => 'Associado',
            self::ASSOCIADO_PRO => 'Associado Pro',
            self::ADMIN => 'Adminitrador',
        };
    }
}
