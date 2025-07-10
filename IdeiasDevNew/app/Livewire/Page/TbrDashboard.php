<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;
use Carbon\Carbon;

class TbrDashboard extends Component
{
    use InteractsWithBanner;

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

    public function mount()
    {
        $this->loadEvents();
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

    public function saveEventsToStorage()
    {
        $jsonPath = 'tbr/json/data.json';
        Storage::disk('public')->put($jsonPath, json_encode($this->events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
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
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editEventName = null;
        $this->editEventDate = null;
        $this->selectedEventId = null;
    }

    public function updateEvent()
    {
        $this->validate([
            'editEventName' => 'required|min:2',
            'editEventDate' => 'required|date',
        ]);

        foreach ($this->events as &$event) {
            if ($event['id'] === $this->selectedEventId) {
                $event['nome'] = $this->editEventName;
                $event['data'] = $this->editEventDate;
                break;
            }
        }

        $this->saveEventsToStorage();
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

    // Getter para retornar modalidades da categoria selecionada
    public function getModalitiesProperty()
    {
        if (!$this->selectedCategory) {
            return [];
        }

        $category = collect(config('tbr-config.categories'))->firstWhere('id', $this->selectedCategory);
        if (!$category) {
            return [];
        }

        // Aqui você usa o valor da chave 'modalitie' da categoria para buscar modalidades
        $modalitie_level = $category['modalitie'] ?? 'basic';

        // Recupera modalidades do nível exato (sem merge)
        $modalities = config("tbr-config.modalities_by_level.$modalitie_level") ?? [];

        return $modalities;
    }

    public function render()
    {
        return view('livewire.page.tbr-dashboard', [
            'events' => $this->events ?? [],
            'categories' => config('tbr-config.categories') ?? [],
            'modalities' => $this->modalities,
        ])->layout('layouts.app-sidebar');
    }
}
