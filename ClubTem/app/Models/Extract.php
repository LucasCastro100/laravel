<?php

namespace App\Models;

use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class Extract extends Model
{
    use HasFactory, HasUuids;

    private $query;
    private $queryAPI;

    protected $fillable = [
        'date_service',
        'value_total',
        'value_exchange',
        'transaction_financial',
        'service_product',
        'description',
        'service_provider_id',
        'service_taker_id',
        'verified',
        'activated'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function profileProvider()
    {
        return $this->belongsTo(Client::class, 'service_provider_id', 'user_id');
    }

    public function profileTaker()
    {
        return $this->belongsTo(Client::class, 'service_taker_id', 'user_id');
    }

    public function initializeQuery()
    {
        // $this->query = Extract::with(['profileProvider', 'profileTaker'])->withTrashed()->orderBy('date_service', 'desc');
        $this->query = Extract::with(['profileProvider', 'profileTaker'])->orderBy('date_service', 'desc');
        return $this->query;
    }

    public function getAllExchange()
    {
        $newQuery = $this->initializeQuery()->paginate(10)->withQueryString();
        return $newQuery;
    }

    public function getExchange(string $uuid)
    {
        $newQuery = $this->initializeQuery();
        return $newQuery->where('uuid', $uuid)->first();
    }

    public function getProviderOrTaker(int $userID)
    {
        $newQuery = $this->initializeQuery();
        return $newQuery->where('service_provider_id', $userID)->orWhere('service_taker_id', $userID)->paginate(10)->withQueryString();
    }

    public function pdf(int $userID, $partnerID)
    {
        $newPartnerId = $partnerID === 'null' ? 'null' : intval($partnerID);
        $newQuery = $this->initializeQuery();

        $newQuery->where(function ($query) use ($userID) {
            $query->where('service_provider_id', $userID)
                ->orWhere('service_taker_id', $userID);
        });

        if ($newPartnerId != 'null') {
            $newQuery->where(function ($query) use ($newPartnerId) {
                $query->where('service_provider_id', $newPartnerId)
                    ->orWhere('service_taker_id', $newPartnerId);
            });
        } else {
            $newQuery->whereNull('service_taker_id');
        }      

        return $newQuery->get();
    }


    public function getAllClients(int $id)
    {
        $newQuery = $this->initializeQuery();        
        $exchanges = $newQuery->where('service_provider_id', $id)->orWhere('service_taker_id', $id)->get();

        $exchangeNew = Auth::user()->role->value > 2 ? $newQuery->get() : $exchanges;

        // Inicializa um array para organizar as permutas por usuário vinculado e separar os valores de compra e venda
        $organizedExchanges = [];
        
        // Itera sobre as permutas e organiza por usuário vinculado
        foreach ($exchangeNew as $exchange) {            
            $providerId = $exchange->service_provider_id;
            $takerId = $exchange->service_taker_id;

            // Se o usuário autenticado não é o provider ou taker, organize as permutas pelo outro usuário vinculado
            if ($providerId !== $id) {
                if (!isset($organizedExchanges[$providerId])) {
                    $organizedExchanges[$providerId] = [];
                }
                $organizedExchanges[$providerId][] = $exchange;
            }

            if ($takerId !== $id) {
                if (!isset($organizedExchanges[$takerId])) {
                    $organizedExchanges[$takerId] = [];
                }
                $organizedExchanges[$takerId][] = $exchange;
            }
        }

        // Ordena os grupos de permutas por usuário vinculado
        ksort($organizedExchanges);

        return $organizedExchanges;
    }

    public function addExtractsAllClients()
    {
        $extracts = $this->getAllClients(Auth::user()->id);
        $exchangesArray = [];

        $totalDebito = 0;
        $totalCredito = 0;
        $totalDinheiro = 0;

        foreach ($extracts as $key => $exchanges) {
            $valueDebito = 0;
            $valueCredito = 0;
            $valueTransacao = 0;
            $qtdExchanges = 0;

            $client = Client::where('user_id', $key)->first();

            $name = (empty($key) && $client == null) || empty($client->name) ? 'Sem registro' : $client->name;
            $partner_id = $key == '' ? 0 : $key;

            foreach ($exchanges as $value) {
                $valueTransacao += $value->transaction_financial;

                $valueDebito +=  $value->service_provider_id == Auth::user()->id ? 0 : $value->value_exchange;
                $valueCredito += $value->service_provider_id == Auth::user()->id ? $value->value_exchange : 0;

                $qtdExchanges += 1;
            }

            $valueSaldo = $valueCredito - $valueDebito;

            $exchangesArray[] = [
                'user_id' => Auth::user()->id,
                'partner_id' => $partner_id,
                'name' => $name,
                'negotiations' => $qtdExchanges,
                'valueTransacao' => $valueTransacao,
                'valueDebito' => $valueDebito,
                'valueCredito' => $valueCredito,
                'valueSaldo' => $valueSaldo,
            ];
        }

        //Somando todos valores
        foreach ($exchangesArray as $key => $item) {
            $totalDebito += $item['valueDebito'];
            $totalCredito += $item['valueCredito'];
        }

        $totalSaldo = $totalCredito - $totalDebito;

        //Adicionando os valores dentro do vetor
        $values = [
            'credito' => $totalCredito,
            'debito' => $totalDebito,
            'saldo' => $totalSaldo,
        ];

        // Cria uma coleção para paginação
        $collection = collect($exchangesArray);

        // Define os parâmetros de paginação
        $perPage = 10; // número de itens por página
        $currentPage = request()->input('page', 1);
        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Cria o LengthAwarePaginator
        $paginatedExchanges = new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $finalArray = [
            'exchanges' => $paginatedExchanges,
            'values' => $values,
        ];

        return $finalArray;
    }
}
