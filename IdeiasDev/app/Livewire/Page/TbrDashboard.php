<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\IbgeService;

class TbrDashboard extends Component
{
    use InteractsWithBanner;

    public $title = 'TBR - Dashboard';

    public array $events = [];
    protected $listeners = ['eventCreated' => 'loadEvents'];

    public bool $showScoreModal = false;
    public bool $showEditModal = false;
    public bool $showDeleteModal = false;

    public ?string $selectedEventId = null;
    public ?string $selectedEventName = null;
    public ?string $selectedCategory = null;

    public ?string $editEventName = null;
    public ?string $editEventDate = null;

    // Configuração ranking para edição
    public array $editRankingConfig = [
        'modalities_to_show' => [],
        'top_positions' => 3,
        'general_top_positions' => 3,
    ];

    public $showSidebar = true;

    public $editEventStatus;

    // Região - Estado - Cidade
    public $editSelectedRegion = null;     // nome digitado
    public $editSelectedRegionId = null;   // id resolvido

    public $editSelectedState = null;
    public $editSelectedStateId = null;

    public $editSelectedCity = null;
    public $editSelectedCityId = null;

    public $regions = [];
    public $filteredEditStates = [];
    public $filteredEditCities = [];

    protected IbgeService $ibge;

    public function boot(IbgeService $ibge)
    {
        $this->ibge = $ibge;
    }

    public function mount()
    {
        $this->regions = $this->ibge->getRegions();

        $this->resetLocation();
        $this->loadEvents();
    }

    private function resetLocation()
    {
        $this->filteredEditStates = [];
        $this->filteredEditCities = [];
        $this->editSelectedRegion = null;
        $this->editSelectedRegionId = null;
        $this->editSelectedState = null;
        $this->editSelectedStateId = null;
        $this->editSelectedCity = null;
        $this->editSelectedCityId = null;
    }

    public function updatedEditSelectedRegion($value)
    {
        $region = collect($this->regions)->firstWhere('nome', $value);
        $this->editSelectedRegionId = $region['id'] ?? null;

        $this->editSelectedState = null;
        $this->editSelectedStateId = null;
        $this->editSelectedCity = null;
        $this->editSelectedCityId = null;

        $this->filteredEditStates = $this->editSelectedRegionId
            ? $this->ibge->getStatesByRegion($this->editSelectedRegionId)
            : [];
    }

    public function updatedEditSelectedState($value)
    {
        $state = collect($this->filteredEditStates)->firstWhere('nome', $value);
        $this->editSelectedStateId = $state['id'] ?? null;

        $this->editSelectedCity = null;
        $this->editSelectedCityId = null;

        $this->filteredEditCities = $this->editSelectedStateId
            ? $this->ibge->getCitiesByState($this->editSelectedStateId)
            : [];
    }

    public function updatedEditSelectedCity($value)
    {
        $city = collect($this->filteredEditCities)->firstWhere('nome', $value);
        $this->editSelectedCityId = $city['id'] ?? null;
    }

    public function loadEvents()
    {
        $jsonPath = 'tbr/json/data.json';

        if (Storage::disk('public')->exists($jsonPath)) {
            $json = Storage::disk('public')->get($jsonPath);
            $this->events = json_decode($json, true) ?? [];

            usort($this->events, function ($a, $b) {
                return Carbon::parse($a['data'])->timestamp <=> Carbon::parse($b['data'])->timestamp;
            });
        } else {
            $this->events = [];
        }
    }

    private function saveEventsToStorage($events = null)
    {
        $jsonPath = 'tbr/json/data.json';

        // Se não passar $events, usa todos os da memória
        $eventsToSave = $events ?? $this->events;

        Storage::disk('public')->put(
            $jsonPath,
            json_encode($eventsToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function openScoreModal(string $eventId)
    {
        $this->selectedEventId = $eventId;
        $event = collect($this->events)->firstWhere('id', $eventId);
        $this->selectedEventName = $event['nome'] ?? 'Evento';

        $this->selectedCategory = null;
        $this->showScoreModal = true;
    }

    public function closeScoreModal()
    {
        $this->showScoreModal = false;
        $this->selectedCategory = null;
    }

    public function openEditModal(string $eventId)
    {
        $event = collect($this->events)->firstWhere('id', $eventId);

        if ($event) {
            $this->selectedEventId = $eventId;
            $this->editEventName = $event['nome'] ?? '';
            $this->editEventDate = $event['data'] ?? '';

            // Aqui pega o status do evento do JSON (assumindo que seja 0 ou 1)
            $this->editEventStatus = isset($event['status']) ? (string) $event['status'] : '0';

            // Config ranking
            $this->editRankingConfig = [
                'modalities_to_show' => $event['ranking_config']['modalities_to_show'] ?? [],
                'top_positions' => $event['ranking_config']['top_positions'] ?? 3,
                'general_top_positions' => $event['ranking_config']['general_top_positions'] ?? 3,
            ];

            $localizacao = $event['localizacao'] ?? [];

            // Corrigir para atribuir o NOME no input, e o ID na variável auxiliar
            $this->editSelectedRegion = $localizacao['regiao']['nome'] ?? null;
            $this->editSelectedRegionId = $localizacao['regiao']['id'] ?? null;

            if ($this->editSelectedRegionId) {
                $this->filteredEditStates = $this->ibge->getStatesByRegion($this->editSelectedRegionId);
            } else {
                $this->filteredEditStates = [];
            }

            $this->editSelectedState = $localizacao['estado']['nome'] ?? null;
            $this->editSelectedStateId = $localizacao['estado']['id'] ?? null;

            if ($this->editSelectedStateId) {
                $allCities = json_decode(Storage::disk('public')->get('ibge/municipios.json'), true);
                $this->filteredEditCities = collect($allCities)
                    ->where('microrregiao.mesorregiao.UF.id', $this->editSelectedStateId)
                    ->values()
                    ->all();
            } else {
                $this->filteredEditCities = [];
            }

            $this->editSelectedCity = $localizacao['municipio']['nome'] ?? null;
            $this->editSelectedCityId = $localizacao['municipio']['id'] ?? null;

            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editEventName = null;
        $this->editEventDate = null;
        $this->selectedEventId = null;
        $this->editRankingConfig = [
            'modalities_to_show' => [],
            'top_positions' => 3,
            'general_top_positions' => 3,
        ];

        $this->editSelectedRegion = null;
        $this->editSelectedState = null;
        $this->editSelectedCity = null;
        $this->filteredEditStates = [];
        $this->filteredEditCities = [];
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updateEvent()
    {
        $this->validate([
            'editEventName' => 'required|min:2',
            'editEventDate' => 'required|date',
            'editRankingConfig.top_positions' => 'nullable|integer|min:0|max:3',
            'editRankingConfig.general_top_positions' => 'nullable|integer|min:0|max:5',
            'editRankingConfig.modalities_to_show' => 'nullable|array',
            'editRankingConfig.modalities_to_show.*' => 'in:ap,mc,om,te,dp',
        ]);

        foreach ($this->events as &$event) {
            if ($event['id'] === $this->selectedEventId) {

                // Atualiza meta-dados
                $event['nome'] = $this->editEventName;
                $event['data'] = $this->editEventDate;

                // Busca objetos completos com base no nome selecionado
                $region = $this->editSelectedRegion
                    ? collect($this->regions)->firstWhere('nome', $this->editSelectedRegion)
                    : null;

                $state = $this->editSelectedState
                    ? collect($this->filteredEditStates)->firstWhere('nome', $this->editSelectedState)
                    : null;

                $city = $this->editSelectedCity
                    ? collect($this->filteredEditCities)->firstWhere('nome', $this->editSelectedCity)
                    : null;

                $event['status'] = (int) $this->editEventStatus;

                // Atualiza localização simplificada
                $event['localizacao'] = [
                    'regiao' => $region
                        ? [
                            'id' => $region['id'],
                            'sigla' => $region['sigla'] ?? null,
                            'nome' => $region['nome'],
                        ]
                        : null,

                    'estado' => $state
                        ? [
                            'id' => $state['id'],
                            'sigla' => $state['sigla'] ?? null,
                            'nome' => $state['nome'],
                        ]
                        : null,

                    'municipio' => $city
                        ? [
                            'id' => $city['id'],
                            'nome' => $city['nome'],
                        ]
                        : null,
                ];

                // Mantém ranking_config e atualiza parcialmente
                $event['ranking_config'] = $event['ranking_config'] ?? [];

                $event['ranking_config']['modalities_to_show'] =
                    is_array($this->editRankingConfig['modalities_to_show'])
                    ? $this->editRankingConfig['modalities_to_show']
                    : ($event['ranking_config']['modalities_to_show'] ?? []);

                $event['ranking_config']['top_positions'] =
                    max(0, (int)($this->editRankingConfig['top_positions']
                        ?? ($event['ranking_config']['top_positions'] ?? 0)));

                $event['ranking_config']['general_top_positions'] =
                    max(0, (int)($this->editRankingConfig['general_top_positions']
                        ?? ($event['ranking_config']['general_top_positions'] ?? 0)));

                break;
            }
        }

        $this->saveEventsToStorage($this->events);

        $this->banner('Evento atualizado com sucesso!');        
        $this->closeEditModal();
        $this->loadEvents();
    }


    public function openDeleteModal(string $eventId)
    {
        $this->selectedEventId = $eventId;
        $event = collect($this->events)->firstWhere('id', $eventId);
        $this->selectedEventName = $event['nome'] ?? '';
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->selectedEventId = null;
        $this->selectedEventName = null;
    }

    public function deleteEvent()
    {
        $this->events = array_filter($this->events, fn($event) => $event['id'] !== $this->selectedEventId);

        $this->saveEventsToStorage();
        $this->banner('Evento apagado com sucesso!');
        $this->closeDeleteModal();
        $this->loadEvents();
    }

    public function updatedSelectedCategory($value)
    {
        // Só para disparar reatividade se precisar
    }

    public function getModalitiesProperty()
    {
        if (!$this->selectedCategory) {
            return [];
        }

        $category = collect(config('tbr-config.categories'))->firstWhere('id', $this->selectedCategory);
        if (!$category) {
            return [];
        }

        $modalitie_level = $category['modalitie'] ?? 'basic';

        $modalities = config("tbr-config.modalities_by_level.$modalitie_level") ?? [];

        return $modalities;
    }

    public function render()
    {
        return view('livewire.page.tbr-dashboard', [
            'events' => $this->events ?? [],
            'categories' => config('tbr-config.categories') ?? [],
            'modalities' => $this->modalities,
            'regions' => $this->regions,
            'filteredEditStates' => $this->filteredEditStates,
            'filteredEditCities' => $this->filteredEditCities,
        ])->layout('layouts.app-sidebar', [
            'showSidebar' => $this->showSidebar,
            'title' => $this->title
        ]);
    }
}
