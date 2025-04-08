<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Connection;
use App\Models\Extract;
use App\Models\TypeService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class Associate extends Component
{
    use WithPagination;

    public $searchName = '', $searchCity = '', $searchService = '';
    public $viewAssocaiate = false;
    public $clientsModal, $connectedTypeServices;

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function updatingSearchCity()
    {
        $this->resetPage();
    }

    public function updatingSearchService()
    {
        $this->resetPage();
    }

    public function getAssociate($id)
    {
        $this->clientsModal = null;
        $this->connectedTypeServices = [];

        // Buscar os dados do cliente pelo ID
        $this->clientsModal = Client::find($id);

        $servicesId = $this->clientsModal->connected_type_services;
        if ($servicesId != null &&  $servicesId != []) {
            $this->connectedTypeServices = TypeService::whereIn('id', $servicesId)->get();
        }

        $this->viewAssocaiate = true;
    }

    protected $listeners = ['clientSelected' => 'handleClientSelected'];

    public function handleClientSelected($clients)
    {
        $this->clientsModal = $clients;
    }

    public function closeModal()
    {
        $this->viewAssocaiate = false;
        $this->clientsModal = null;  // Limpa a variável client para garantir que o modal seja resetado
    }

    public function render()
    {
        $clients = Client::query()
            ->where('associate', 1)
            ->when($this->searchName, function ($query) {
                return $query->where('name', 'like', '%' . $this->searchName . '%');
            })
            ->when($this->searchCity, function ($query) {
                return $query->whereHas('city', function ($q) {
                    $q->where('city', 'like', '%' . $this->searchCity . '%');
                });
            })
            ->when($this->searchService, function ($query) {
                return $query->whereHas('typeService', function ($q) {
                    $q->where('type_service', 'like', '%' . $this->searchService . '%');
                });
            })
            ->when(Auth::check(), function ($query) {
                $roleThreshold = Auth::user()->role->value + 1;
                return $query->whereHas('user', function ($q) use ($roleThreshold) {
                    $q->where('role', '<', $roleThreshold);
                });
            })
            ->get();

        $clients->map(function ($client) {
            $connectionCount = Connection::where('user_id', $client->user_id)
                ->distinct('connected_user_id')
                ->count();

            $client->unique_connections_count = $connectionCount ?: 0;

            return $client;
        });

        $clients->map(function ($client) {
            $connectionCount = Extract::where('service_provider_id', $client->user_id)
                ->count();

            $client->extract_connections_count = $connectionCount ?: 0;

            return $client;
        });

        $clients = $clients->sort(function ($a, $b) {
            // Comparação por unique_connections_count em ordem decrescente
            if ($a->unique_connections_count !== $b->unique_connections_count) {
                return $b->unique_connections_count <=> $a->unique_connections_count;
            }

            // Comparação por extract_connections_count em ordem decrescente
            if ($a->extract_connections_count !== $b->extract_connections_count) {
                return $b->extract_connections_count <=> $a->extract_connections_count;
            }

            // Comparação por name em ordem crescente
            return $a->name <=> $b->name;
        });

       // Cria uma coleção para paginação
        $collection = collect($clients);

        // Define os parâmetros de paginação
        $perPage = 10; // número de itens por página
        $currentPage = request()->input('page', 1);
        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Cria o LengthAwarePaginator
        $paginatedAssociates = new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // dd($paginatedAssociates);

        return view('livewire.associate', ['clients' => $paginatedAssociates]);
    }
}
