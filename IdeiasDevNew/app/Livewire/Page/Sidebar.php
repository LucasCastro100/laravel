<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Support\Str;

class Sidebar extends Component
{
    use InteractsWithBanner;

    // Modal flags
    public bool $showEventModal = false;
    public bool $showTeamModal = false;
    public bool $confirmClearStorage = false;

    // --- Dados para evento ---
    public $eventName = '';
    public $eventDate = '';

    // --- Dados para equipes ---
    public $selectedEventIndex = null; // índice do evento selecionado para cadastrar equipe
    public $numTeams = 1;
    public $teams = [
        [
            'name' => '',
            'category' => 'kids1',
            'mc' => 0,
            'om' => 0,
            'te' => 0,
            'dp' => 0,
        ],
    ];
    public $categories = ['kids1', 'kids2', 'middle1', 'middle2', 'high'];

    // --- Dados carregados ---
    public $events = []; // array de eventos do JSON

    // ----------- Métodos -----------

    // --- Eventos ---

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
        $this->resetErrorBag('eventName');
        $this->resetErrorBag('eventDate');
    }

    public function saveEvent()
    {
        $this->validate([
            'eventName' => 'required|string|min:2',
            'eventDate' => 'required|date',
        ]);

        $uuid = Str::upper(Str::random(12));

        $newEvent = [
            'id' => $uuid, // Gera um ID único para o evento
            'nome' => $this->eventName,
            'data' => $this->eventDate,
            'equipes' => [],
        ];

        $this->loadEvents();

        // Verifica se evento já existe
        foreach ($this->events as $event) {
            if (
                strtolower($event['nome']) === strtolower($newEvent['nome']) &&
                $event['data'] === $newEvent['data']
            ) {
                $this->addError('eventName', 'Evento já cadastrado com este nome e data.');
                return;
            }
        }

        // Adiciona novo evento
        $this->events[] = $newEvent;

        $this->saveEventsToStorage();

        $this->banner('Evento cadastrado com sucesso!');

        $this->closeEventModal();
    }

    // --- Equipes ---

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
        $this->teams = [
            [
                'name' => '',
                'category' => 'kids1',
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

        if ($value > $count) {
            for ($i = $count; $i < $value; $i++) {
                $this->teams[] = [
                    'name' => '',
                    'category' => 'kids1',
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
        $this->validate([
            'selectedEventIndex' => 'required|integer|min:0',
            'teams.*.name' => 'required|min:2',
            'teams.*.category' => 'required|in:' . implode(',', $this->categories),
        ], [
            'selectedEventIndex.required' => 'Você deve selecionar um evento.',
        ]);

        $this->loadEvents();

        // Verifica índice do evento selecionado
        if (!isset($this->events[$this->selectedEventIndex])) {
            $this->addError('selectedEventIndex', 'Evento selecionado inválido.');
            return;
        }

        // Adiciona as equipes no evento selecionado
        $evento = &$this->events[$this->selectedEventIndex];

        foreach ($this->teams as $team) {
            // Opcional: evitar duplicatas na equipe pelo nome dentro do evento
            $exists = false;
            foreach ($evento['equipes'] as $existingTeam) {
                if (strtolower($existingTeam['name']) === strtolower($team['name'])) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $evento['equipes'][] = $team;
            }
        }

        // Salva o JSON atualizado
        $this->saveEventsToStorage();

        $this->banner('Equipes cadastradas com sucesso!');

        $this->closeTeamModal();
    }

    // --- Limpar armazenamento ---
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
        $this->clearStorage(); // já existe esse método!
        $this->confirmClearStorage = false;
    }

    // --- Funções auxiliares para carregar/salvar eventos ---

    public function loadEvents()
    {
        $jsonPath = 'dados-tbr.json';
        if (Storage::exists($jsonPath)) {
            $this->events = json_decode(Storage::get($jsonPath), true);
        } else {
            $this->events = [];
        }

        return $this->events;
    }


    public function saveEventsToStorage()
    {
        $jsonPath = 'dados-tbr.json';
        Storage::put($jsonPath, json_encode($this->events, JSON_PRETTY_PRINT));
    }

    // --- Função para limpar JSON e resetar formulários ---

    public function clearStorage()
    {
        Storage::put('dados-tbr.json', json_encode([]));

        $this->resetEventForm();
        $this->resetTeamForm();

        $this->banner('Dados do JSON apagados e formulários resetados!');
    }

    // ----------- Render -----------

    public function render()
    {
        return view('livewire.page.sidebar', [
            'events' => $this->events,
        ]);
    }
}
