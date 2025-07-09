<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Support\Str;

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

    // ----------- Métodos -----------

    /**
     * Abre o modal de cadastro de evento.
     * Também carrega os eventos atuais do JSON.
     */
    public function openEventModal()
    {
        $this->loadEvents();
        $this->showEventModal = true;
    }

    /**
     * Fecha o modal de cadastro de evento
     * e reseta os campos do formulário.
     */
    public function closeEventModal()
    {
        $this->showEventModal = false;
        $this->resetEventForm();
    }

    /**
     * Reseta os campos do formulário de evento
     * e limpa possíveis erros de validação.
     */
    public function resetEventForm()
    {
        $this->eventName = '';
        $this->eventDate = '';
        $this->resetErrorBag('eventName');
        $this->resetErrorBag('eventDate');
    }

    /**
     * Valida e salva um novo evento no JSON.
     * Verifica se o evento já existe antes de adicionar.
     */
    public function saveEvent()
    {
        $this->validate([
            'eventName' => 'required|string|min:2',
            'eventDate' => 'required|date',
        ]);

        $newEvent = [
            'id' => Str::upper(Str::random(12)),
            'nome' => $this->eventName,
            'data' => $this->eventDate,
            'equipes' => [],
        ];

        $this->loadEvents();

        foreach ($this->events as $event) {
            if (
                strtolower($event['nome']) === strtolower($newEvent['nome']) &&
                $event['data'] === $newEvent['data']
            ) {
                $this->addError('eventName', 'Evento já cadastrado com este nome e data.');
                return;
            }
        }

        $this->events[] = $newEvent;
        $this->saveEventsToStorage();

        $this->banner('Evento cadastrado com sucesso!');
        $this->dispatch('eventCreated');
        $this->closeEventModal();
    }

    /**
     * Abre o modal de cadastro de equipes.
     * Exibe alerta caso não haja eventos cadastrados.
     */
    public function openTeamModal()
    {
        $this->loadEvents();
        if (empty($this->events)) {
            $this->warningBanner('Você precisa cadastrar pelo menos um evento antes de adicionar equipes.');
            return;
        }

        $this->showTeamModal = true;
    }

    /**
     * Fecha o modal de equipes e reseta o formulário.
     */
    public function closeTeamModal()
    {
        $this->showTeamModal = false;
        $this->resetTeamForm();
    }

    /**
     * Reseta os campos do formulário de equipes,
     * incluindo quantidade, dados das equipes e erros.
     */
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

    /**
     * Atualiza o número de equipes no formulário,
     * adicionando ou removendo conforme o valor informado.
     */
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

    /**
     * Valida e salva as equipes vinculadas ao evento selecionado.
     * Evita duplicatas pelo nome da equipe.
     */
    public function saveTeams()
    {
        $categorySlugs = collect(config('tbr-config.categories'))->pluck('slug')->toArray();

        $this->validate([
            'selectedEventIndex' => 'required|integer|min:0',
            'teams.*.name' => 'required|min:2',
            'teams.*.category' => 'required|in:' . implode(',', $categorySlugs),
        ], [
            'selectedEventIndex.required' => 'Você deve selecionar um evento.',
        ]);

        $this->loadEvents();

        if (!isset($this->events[$this->selectedEventIndex])) {
            $this->addError('selectedEventIndex', 'Evento selecionado inválido.');
            return;
        }

        $evento = &$this->events[$this->selectedEventIndex];

        foreach ($this->teams as $team) {
            $exists = false;
            foreach ($evento['equipes'] as $existingTeam) {
                if (strtolower($existingTeam['name']) === strtolower($team['name'])) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $evento['equipes'][] = [
                    'id' => Str::upper(Str::random(12)),
                    'name' => $team['name'],
                    'category' => $team['category'],
                    'modalities' => [
                        'mc' => [
                            'nota' => [],      // array vazio
                            'total' => 0,
                            'comentario' => '',
                        ],
                        'om' => [
                            'nota' => [],      // array vazio
                            'total' => 0,
                            'comentario' => '',
                        ],
                        'te' => [
                            'nota' => [],      // array vazio
                            'total' => 0,
                            'comentario' => '',
                        ],
                        'dp' => [
                            'nota' => [
                                'r1' => [],
                                'r2' => [],
                                'r3' => [],
                            ],
                            'total' => 0,
                            'comentario' => '',
                        ],
                    ],
                    'nota_total' => 0,  // campo nota_total zerado
                ];
            }
        }

        $this->saveEventsToStorage();

        $this->banner('Equipes cadastradas com sucesso!');
        $this->closeTeamModal();
    }

    /**
     * Exibe confirmação para limpar o JSON do storage.
     */
    public function askToClearStorage()
    {
        $this->confirmClearStorage = true;
    }

    /**
     * Cancela a ação de limpar o JSON.
     */
    public function cancelClearStorage()
    {
        $this->confirmClearStorage = false;
    }

    /**
     * Confirma e limpa o JSON, reseta formulários e exibe banner.
     */
    public function confirmAndClearStorage()
    {
        $this->clearStorage();
        $this->confirmClearStorage = false;
    }

    /**
     * Carrega os eventos do JSON.
     * @return array
     */
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

    /**
     * Salva os eventos no arquivo JSON.
     */
    public function saveEventsToStorage()
    {
        $jsonPath = 'tbr/json/data.json';

        Storage::disk('public')->put($jsonPath, json_encode($this->events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Limpa o JSON de eventos, reseta formulários e notifica o usuário.
     */
    public function clearStorage()
    {
        $jsonPath = 'tbr/json/data.json';

        Storage::disk('public')->put($jsonPath, json_encode([]));

        $this->resetEventForm();
        $this->resetTeamForm();

        $this->banner('Dados do JSON apagados e formulários resetados!');

        $this->dispatch('eventCreated');
    }

    /**
     * Renderiza a view 'sidebar' passando eventos e categorias.
     */
    public function render()
    {
        return view('livewire.page.sidebar', [
            'events' => $this->events,
            'categories' => config('tbr-config.categories') ?? [],
        ]);
    }
}
