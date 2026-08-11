<?php

namespace App\Enums;

enum DisputeReason: string
{
    case ItemCondition = 'item_condition';
    case ServiceQuality = 'service_quality';
    case Payment = 'payment';
    case NoShow = 'no_show';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::ItemCondition => 'Item não corresponde ao anúncio',
            self::ServiceQuality => 'Serviço não corresponde ao combinado',
            self::Payment => 'Problema com pagamento/créditos',
            self::NoShow => 'Não comparecimento',
            self::Other => 'Outro',
        };
    }
}
