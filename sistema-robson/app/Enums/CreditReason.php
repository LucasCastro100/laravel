<?php

namespace App\Enums;

enum CreditReason: string
{
    case TradeCompletion = 'trade_completion';
    case SignupBonus = 'signup_bonus';
    case AdminAdjustment = 'admin_adjustment';

    public function label(): string
    {
        return match ($this) {
            self::TradeCompletion => 'Permuta concluída',
            self::SignupBonus => 'Bônus de cadastro',
            self::AdminAdjustment => 'Ajuste administrativo',
        };
    }
}
