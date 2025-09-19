<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Support\Str;
use App\Services\IbgeService;

class Sidebar extends Component
{
    use InteractsWithBanner;

    // --- Flags para modais ---
    public bool $showEventModal = false;
    public bool $showTeamModal = false;
    public bool $confirmClearStorage = false;

    // --- Dados para cadastro de evento ---
    public $eventName = '';
    public $eventDate = '';

    // Config ranking para o evento novo
    public $rankingConfig = [
        'modalities_to_show' => [],       // array das modalidades selecionadas
        'top_positions' => 0,              // posições mostradas por modalidade (0 a 3)
        'general_top_positions' => 3,      // posições mostradas no ranking geral (0 a 5)
    ];

    // --- Dados para cadastro de equipes ---
    public $selectedEventIndex = null;
    public $numTeams = 1;
    public $teams = [
        [
            'name' => '',
            'category' => 'baby',
            'mc' => 0,
            'om' => 0,
            'te' => 0,
            'dp' => 0,
        ],
    ];

    // --- Dados carregados dos eventos ---
    public $events = [];

    // --- Propriedades para seleção ---
    public $selectedRegion = null;      // nome digitado
    public $selectedRegionId = null;    // id real

    public $selectedState = null;
    public $selectedStateId = null;

    public $selectedCity = null;
    public $selectedCityId = null;

    public $regions = [];
    public $filteredStates = [];
    public $filteredCities = [];

    protected IbgeService $ibge;

    public function boot(IbgeService $ibge)
    {
        $this->ibge = $ibge;
    }

    public function mount()
    {
        $this->regions = $this->ibge->getRegions();
        $this->filteredStates = [];
        $this->filteredCities = [];
        $this->resetLocation();
    }

    private function resetLocation()
    {
        $this->selectedRegion = null;
        $this->selectedRegionId = null;
        $this->selectedState = null;
        $this->selectedStateId = null;
        $this->selectedCity = null;
        $this->selectedCityId = null;
        $this->filteredStates = [];
        $this->filteredCities = [];
    }

    public function updatedSelectedRegion($value)
    {
        $region = collect($this->regions)->firstWhere('nome', $value);
        $this->selectedRegionId = $region['id'] ?? null;

        $this->selectedState = null;
        $this->selectedStateId = null;
        $this->selectedCity = null;
        $this->selectedCityId = null;

        $this->filteredStates = $this->selectedRegionId
            ? $this->ibge->getStatesByRegion($this->selectedRegionId)
            : [];
    }

    public function updatedSelectedState($value)
    {
        $state = collect($this->filteredStates)->firstWhere('nome', $value);
        $this->selectedStateId = $state['id'] ?? null;

        $this->selectedCity = null;
        $this->selectedCityId = null;

        $this->filteredCities = $this->selectedStateId
            ? $this->ibge->getCitiesByState($this->selectedStateId)
            : [];
    }

    public function updatedSelectedCity($value)
    {
        $city = collect($this->filteredCities)->firstWhere('nome', $value);
        $this->selectedCityId = $city['id'] ?? null;
    }

    public function openEventModal()
    {
        $this->loadEvents();
        $this->showEventModal = true;
    }

    public function closeEventModal()
    {
        $this->showEventModal = false;
        $this->resetEventForm();
    }

    public function resetEventForm()
    {
        $this->eventName = '';
        $this->eventDate = '';

        $this->rankingConfig = [
            'modalities_to_show' => [],
            'top_positions' => 0,
            'general_top_positions' => 3,
        ];

        // Reset da localização
        $this->selectedRegion = null;
        $this->selectedState = null;
        $this->selectedCity = null;
        $this->filteredStates = [];
        $this->filteredCities = [];

        // Reset de validações
        $this->resetErrorBag('eventName');
        $this->resetErrorBag('eventDate');
        $this->resetErrorBag('rankingConfig');
        $this->resetErrorBag('selectedRegion');
        $this->resetErrorBag('selectedState');
        $this->resetErrorBag('selectedCity');
    }

    public function saveEvent()
    {
        // Validação dos campos do formulário de evento
        $this->validate([
            'eventName' => 'required|string|min:2',
            'eventDate' => 'required|date',
            'rankingConfig.top_positions' => 'nullable|integer|min:0|max:3',
            'rankingConfig.general_top_positions' => 'nullable|integer|min:0|max:5',
            'rankingConfig.modalities_to_show' => 'nullable|array',
            'rankingConfig.modalities_to_show.*' => 'in:ap,mc,om,te,dp',
        ], [
            'rankingConfig.top_positions.integer' => 'O número de posições por modalidade deve ser um número inteiro.',
            'rankingConfig.top_positions.min' => 'O número de posições por modalidade não pode ser negativo.',
            'rankingConfig.top_positions.max' => 'O número de posições por modalidade não pode ser maior que 3.',
            'rankingConfig.general_top_positions.integer' => 'O número de posições no ranking geral deve ser um número inteiro.',
            'rankingConfig.general_top_positions.min' => 'O número de posições no ranking geral não pode ser negativo.',
            'rankingConfig.general_top_positions.max' => 'O número de posições no ranking geral não pode ser maior que 5.',
            'rankingConfig.modalities_to_show.*.in' => 'Modalidade inválida selecionada.',
        ]);

        // Cria novo evento com ID aleatório e estrutura padrão
        $newEvent = [
            'id' => Str::upper(Str::random(12)),
            'nome' => $this->eventName,
            'data' => $this->eventDate,
            'status' => 0,
            // Localização simplificada para salvar só id, sigla e nome, sem dados extras
            'localizacao' => [
                'regiao' => $this->selectedRegion
                    ? [
                        'id' => $this->selectedRegionId,
                        'sigla' => collect($this->regions)->firstWhere('id', $this->selectedRegionId)['sigla'] ?? null,
                        'nome' => $this->selectedRegion,
                    ]
                    : null,
                'estado' => $this->selectedState
                    ? [
                        'id' => $this->selectedStateId,
                        'sigla' => collect($this->filteredStates)->firstWhere('id', $this->selectedStateId)['sigla'] ?? null,
                        'nome' => $this->selectedState,
                    ]
                    : null,
                'municipio' => $this->selectedCity
                    ? [
                        'id' => $this->selectedCityId,
                        'nome' => $this->selectedCity,
                    ]
                    : null,
            ],
            'ranking_config' => [
                'modalities_to_show' => is_array($this->rankingConfig['modalities_to_show'])
                    ? $this->rankingConfig['modalities_to_show']
                    : [],
                'top_positions' => max(0, (int)($this->rankingConfig['top_positions'] ?? 0)),
                'general_top_positions' => max(0, (int)($this->rankingConfig['general_top_positions'] ?? 0)),
            ],
            'equipes' => [],
        ];

        // Carrega eventos atuais para evitar duplicatas
        $this->loadEvents();

        // Verifica duplicidade pelo nome e data
        foreach ($this->events as $event) {
            if (
                strtolower($event['nome']) === strtolower($newEvent['nome']) &&
                $event['data'] === $newEvent['data']
            ) {
                $this->addError('eventName', 'Evento já cadastrado com este nome e data.');
                return;
            }
        }

        // Adiciona novo evento no array e salva JSON
        $this->events[] = $newEvent;
        $this->saveEventsToStorage();

        // $this->banner('Evento cadastrado com sucesso!');
        $this->dispatch('eventCreated');
        $this->closeEventModal();

        session()->flash('success', 'Evento cadastrado com sucesso!');
        return redirect()->route('tbr.dashboard');
    }

    public function openTeamModal()
    {
        $this->loadEvents();
        if (empty($this->events)) {
            $this->warningBanner('Você precisa cadastrar pelo menos um evento antes de adicionar equipes.');
            return;
        }

        $this->showTeamModal = true;
    }

    public function closeTeamModal()
    {
        $this->showTeamModal = false;
        $this->resetTeamForm();
    }

    public function resetTeamForm()
    {
        $this->numTeams = 1;
        $defaultCategorySlug = config('tbr-config.categories')[0]['slug'] ?? 'baby';

        $this->teams = [
            [
                'name' => '',
                'category' => $defaultCategorySlug,
                'mc' => 0,
                'om' => 0,
                'te' => 0,
                'dp' => 0,
            ],
        ];
        $this->selectedEventIndex = null;
        $this->resetErrorBag('teams');
        $this->resetErrorBag('selectedEventIndex');
    }

    public function updatedNumTeams($value)
    {
        $value = (int)$value;
        if ($value < 1) $value = 1;

        $count = count($this->teams);
        $defaultCategorySlug = config('tbr-config.categories')[0]['slug'] ?? 'baby';

        if ($value > $count) {
            for ($i = $count; $i < $value; $i++) {
                $this->teams[] = [
                    'name' => '',
                    'category' => $defaultCategorySlug,
                    'mc' => 0,
                    'om' => 0,
                    'te' => 0,
                    'dp' => 0,
                ];
            }
        } elseif ($value < $count) {
            $this->teams = array_slice($this->teams, 0, $value);
        }
    }

    public function saveTeams()
    {
        $categories = config('tbr-config.categories') ?? [];
        $modalitiesByLevel = config('tbr-config.modalities_by_level') ?? [];

        // Mapear slugs e níveis para validação e montagem das modalidades
        $categorySlugs = collect($categories)->pluck('slug')->toArray();
        $categoryLevels = collect($categories)->mapWithKeys(fn($cat) => [$cat['slug'] => $cat['modalitie'] ?? 'basic'])->toArray();

        // Validação das equipes e evento selecionado
        $this->validate([
            'selectedEventIndex' => 'required|integer|min:0',
            'teams.*.name' => 'required|min:2',
            'teams.*.category' => 'required|in:' . implode(',', $categorySlugs),
        ], [
            'selectedEventIndex.required' => 'Você deve selecionar um evento.',
        ]);

        $this->loadEvents();

        // Valida índice do evento selecionado
        if (!isset($this->events[$this->selectedEventIndex])) {
            $this->addError('selectedEventIndex', 'Evento selecionado inválido.');
            return;
        }

        $evento = &$this->events[$this->selectedEventIndex];

        foreach ($this->teams as $team) {
            $teamNameLower = strtolower($team['name']);

            // Evita adicionar equipes com nome repetido
            $exists = collect($evento['equipes'])->contains(
                fn($existingTeam) => strtolower($existingTeam['name']) === $teamNameLower
            );

            if (!$exists) {
                $categorySlug = $team['category'];
                $modalitie_level = $categoryLevels[$categorySlug] ?? 'basic';
                $modalities = [];

                // Monta modalidades conforme nível da categoria
                foreach ($modalitiesByLevel[$modalitie_level] ?? [] as $modality) {
                    $slug = is_array($modality) ? ($modality['slug'] ?? null) : $modality;

                    if (!$slug || !is_string($slug)) {
                        continue;
                    }

                    if ($slug === 'dp') {
                        $modalities[$slug] = [
                            'nota' => [
                                'r1' => [],
                                'r2' => [],
                                'r3' => [],
                            ],
                            'total' => 0,
                            'comentario' => '',
                        ];
                    } else {
                        $modalities[$slug] = [
                            'nota' => [],
                            'total' => 0,
                            'comentario' => '',
                        ];
                    }
                }

                // Adiciona equipe no evento
                $evento['equipes'][] = [
                    'id' => Str::upper(Str::random(12)),
                    'name' => $team['name'],
                    'category' => $categorySlug,
                    'modalities' => $modalities,
                    'nota_total' => 0,
                ];
            }
        }

        $this->saveEventsToStorage();

        $this->banner('Equipes cadastradas com sucesso!');
        $this->closeTeamModal();
    }

    public function askToClearStorage()
    {
        $this->confirmClearStorage = true;
    }

    public function cancelClearStorage()
    {
        $this->confirmClearStorage = false;
    }

    public function confirmAndClearStorage()
    {
        $this->clearStorage();
        $this->confirmClearStorage = false;
    }

    public function loadEvents()
    {
        $jsonPath = 'tbr/json/data.json';

        if (Storage::disk('public')->exists($jsonPath)) {
            $this->events = json_decode(Storage::disk('public')->get($jsonPath), true);
        } else {
            $this->events = [];
        }

        return $this->events;
    }

    public function saveEventsToStorage()
    {
        $jsonPath = 'tbr/json/data.json';

        Storage::disk('public')->put($jsonPath, json_encode($this->events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function clearStorage()
    {
        $jsonPath = 'tbr/json/data.json';

        Storage::disk('public')->put($jsonPath, json_encode([]));

        $this->resetEventForm();
        $this->resetTeamForm();

        $this->banner('Dados do JSON apagados e formulários resetados!');

        $this->dispatch('eventCreated');
    }

    public function render()
    {
        return view('livewire.page.sidebar', [
            'events' => $this->events,
            'categories' => config('tbr-config.categories') ?? [],
        ]);
    }
}
