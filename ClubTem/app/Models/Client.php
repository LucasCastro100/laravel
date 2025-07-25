<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'cnpj',
        'responsible',
        'state_id',
        'city_id',
        'type_service_id',
        'connected_type_services',
        'whatsapp',
        'instagram',
        'associate',
        'photo',
        'description'
    ];

    protected $casts = [
        'connected_type_services' => 'array',
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function providedServices()
    {
        return $this->hasMany(Extract::class, 'service_provider_id');
    }

    public function takenServices()
    {
        return $this->hasMany(Extract::class, 'service_taker_id');
    }

    public function typeService()
    {
        return $this->belongsTo(TypeService::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function desiredProspectings()
    {
        return $this->hasMany(DesiredProspectingr::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'user_id', 'user_id');
    }

    public function getAssociate()
    {
        // $clients = Client::where('associate', 1)->where('user_id', '<>', Auth::user()->id)->get();
        $clients = Client::where('associate', 1)->get();
        return $clients;
    }

    public function getAll()
    {
        // Pega os clientes cujo usuário associado tem a role dentro do intervalo desejado
        $clients = Client::whereHas('user', function ($query) {
            // Filtra a role do usuário associado, onde a role é maior que 1 e menor que 2
            $query->where('role', '>', 0)->where('role', '<', 3);
        })->with(['user', 'typeService']) // Inclui o usuário e os serviços relacionados
            ->get();

        // Itera sobre os clientes e adiciona os nomes dos serviços e conexões
        $clientsWithServices = $clients->map(function ($client) use ($clients) {
            // Usa os IDs diretamente, pois o cast já converte para array
            $connectedIds = $client->connected_type_services;

            // Verifica se os IDs estão válidos
            if (empty($connectedIds) || !is_array($connectedIds)) {
                $client->service_names = []; // Define como vazio se não houver IDs válidos
            } else {
                // Converte os IDs para inteiros, se necessário
                $connectedIds = array_map('intval', $connectedIds);

                // Busca os nomes dos serviços conectados
                $typeServiceNames = TypeService::whereIn('id', $connectedIds)->pluck('type_service');

                // Adiciona os nomes ao cliente
                $client->service_names = $typeServiceNames->toArray();
            }

            // Obtém o ID do serviço atual do cliente
            $serviceId = $client->typeService->id ?? null;

            // Verifica se o serviço é válido
            if (!$serviceId) {
                $client->connections = []; // Sem conexões
            } else {
                // Encontra os clientes interessados nesse serviço e carrega os clientes associados
                $connections = $clients->filter(function ($otherClient) use ($serviceId, $client) {
                    return $otherClient->id !== $client->id // Evita incluir o cliente atual
                        && is_array($otherClient->connected_type_services)
                        && in_array($serviceId, $otherClient->connected_type_services);
                })->map(function ($otherClient) {
                    // Aqui, carregamos o nome do cliente diretamente
                    return $otherClient->name ?? null;
                });

                // Adiciona as conexões ao cliente
                $client->connections = $connections->toArray();
            }

            return $client;
        });

        // Retorna o vetor com os nomes dos serviços e conexões incluídos
        return $clientsWithServices;
    }

    public function getAllClientsFromExtracts(int $id, int $role)
    {
        return Client::whereHas('user', function ($query) use ($id, $role) {
            $query->where('role', '<', 3)
                ->where('role', '<=', $role)
                ->where('id', '<>', $id);
        })
            ->with('user')
            ->get();
    }
}
