<?php

namespace App\Models;

use App\Enums\TransactionExchangeStatus;
use App\Enums\TransactionExchangeTypePaymant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionExchange extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'exchange_id',    
        'start_date',
        'end_date',
        'contract',
        'value',
        'status',
        'type_payment',
        'proof_payment',
        'description'
    ];

    protected $casts = [
        'status' => TransactionExchangeStatus::class,
        'type_payment' => TransactionExchangeTypePaymant::class
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function getAll(int $userID)
    {
        $filteredControlExchanges = Extract::where('service_provider_id', $userID)
            ->orWhere('service_taker_id', $userID)
            ->with(['extractExchange', 'profileProvider', 'profileTaker'])
            ->get();

        $extractExchanges = $filteredControlExchanges->flatMap(function ($controlExchange) {
            return $controlExchange->extractExchange->map(function ($extract) use ($controlExchange) {
                return [
                    'extract' => $extract,
                    'provider' => $controlExchange->profileProvider,
                    'taker' => $controlExchange->profileTaker,
                    'control_exchange_uuid' => $controlExchange->uuid
                ];
            });
        });

        return $extractExchanges;
    }

    public function sumExtractValuesByUser(string $typeService, int $userID, int $typePrice)
    {
        $filteredControlExchanges = Extract::where($typeService, $userID)
            ->whereHas('extractExchange', function ($query) use ($typePrice) {
                $query->where('type_price', $typePrice);
            })
            ->with(['extractExchange' => function ($query) use ($typePrice) {
                $query->where('type_price', $typePrice);
            }])
            ->get();

        $extractExchanges = $filteredControlExchanges->flatMap(function ($controlExchange) {
            return $controlExchange->extractExchange;
        });

        $totalPrice = $extractExchanges->sum(function ($extractExchange) {
            return (float) $extractExchange->price;
        });

        return $totalPrice;
    }

    public function getSumValues(int $userID)
    {
        $provider = [
            'permuta' => $this->sumExtractValuesByUser('service_provider_id', $userID, 0),
            'pagar' => $this->sumExtractValuesByUser('service_provider_id', $userID, 1),
            'receber' => $this->sumExtractValuesByUser('service_provider_id', $userID, 2),
        ];

        $taker = [
            'permuta' => $this->sumExtractValuesByUser('service_taker_id', $userID, 0),
            'pagar' => $this->sumExtractValuesByUser('service_taker_id', $userID, 2),
            'receber' => $this->sumExtractValuesByUser('service_taker_id', $userID, 1),
        ];

        $totalExtract = [
            ['name' => 'Permuta', 'class' => 'permuta', 'value' => $provider['permuta'] + $taker['permuta']],
            ['name' => 'A pagar', 'class' => 'pagar', 'value' => $provider['pagar'] + $taker['pagar']],
            ['name' => 'A receber', 'class' => 'receber', 'value' => $provider['receber'] + $taker['receber']]
        ];

        return $totalExtract;
    }
}
