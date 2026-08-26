<?php

namespace App\Enums;

/**
 * Tipos de usuário da plataforma (tabela global de roles).
 *
 * @see documentação de negócio: Videomaker / Cliente / Empresa / Administrador
 */
enum UserRole: string
{
    case Administrator = 'administrador';
    case Videomaker = 'videomaker';
    case Cliente = 'cliente';
    case Empresa = 'empresa';

    /**
     * Get the display label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::Administrator => 'Administrador',
            self::Videomaker => 'Videomaker',
            self::Cliente => 'Cliente',
            self::Empresa => 'Empresa',
        };
    }

    /**
     * The role assigned by default to newly registered users.
     */
    public static function default(): self
    {
        return self::Videomaker;
    }

    /**
     * All selectable roles (excluding the administrator).
     *
     * @return array<int, self>
     */
    public static function assignable(): array
    {
        return [
            self::Videomaker,
            self::Cliente,
            self::Empresa,
        ];
    }
}
