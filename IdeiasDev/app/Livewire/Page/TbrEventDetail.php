<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use App\Models\Event;
use App\Services\IbgeService;

class TbrEventDetail extends Component
{
    use InteractsWithBanner;

    public $title = 'TBR - Evento';

    public ?string $eventId = null;
    public ?Event $event = null;

    public bool $showEditModal = false;
    public bool $showDeleteModal = false;

    public ?string $editEventName = null;
    public ?string $editEventDate = null;
    public $editEventStatus;

    public $editSelectedRegion = null;
    public $editSelectedRegionId = null;
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

    public function mount(?string $event_id = null): void
    {
        $this->regions = $this->ibge->getRegions();

        if ($event_id) {
            $this->event = Event::withCount('teams')->find($event_id);
            $this->eventId = $event_id;

            if ($this->event) {
                $this->title = $this->event->name;
            }
        }
    }

    private function resetLocation(): void
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

    public function updatedEditSelectedRegion($value): void
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

    public function updatedEditSelectedState($value): void
    {
        $state = collect($this->filteredEditStates)->firstWhere('nome', $value);
        $this->editSelectedStateId = $state['id'] ?? null;

        $this->editSelectedCity = null;
        $this->editSelectedCityId = null;

        $this->filteredEditCities = $this->editSelectedStateId
            ? $this->ibge->getCitiesByState($this->editSelectedStateId)
            : [];
    }

    public function updatedEditSelectedCity($value): void
    {
        $city = collect($this->filteredEditCities)->firstWhere('nome', $value);
        $this->editSelectedCityId = $city['id'] ?? null;
    }

    public function openEditModal(): void
    {
        $this->authorize('edit');

        if (!$this->event) return;

        $this->editEventName = $this->event->name;
        $this->editEventDate = $this->event->date?->format('Y-m-d');
        $this->editEventStatus = (string) ($this->event->status ? 1 : 0);

        $localizacao = $this->event->location ?? [];

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
            $this->filteredEditCities = $this->ibge->getCitiesByState($this->editSelectedStateId);
        } else {
            $this->filteredEditCities = [];
        }

        $this->editSelectedCity = $localizacao['municipio']['nome'] ?? null;
        $this->editSelectedCityId = $localizacao['municipio']['id'] ?? null;

        $this->showEditModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->editEventName = null;
        $this->editEventDate = null;
        $this->resetLocation();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updateEvent()
    {
        $this->authorize('edit');
        $this->validate([
            'editEventName' => 'required|min:2',
            'editEventDate' => 'required|date',
        ]);

        if (!$this->event) return;

        $region = $this->editSelectedRegion ? collect($this->regions)->firstWhere('nome', $this->editSelectedRegion) : null;
        $state = $this->editSelectedState ? collect($this->filteredEditStates)->firstWhere('nome', $this->editSelectedState) : null;
        $city = $this->editSelectedCity ? collect($this->filteredEditCities)->firstWhere('nome', $this->editSelectedCity) : null;

        $this->event->update([
            'name' => $this->editEventName,
            'date' => $this->editEventDate,
            'status' => (bool) $this->editEventStatus,
            'location' => [
                'regiao' => $region ? ['id' => $region['id'], 'sigla' => $region['sigla'] ?? null, 'nome' => $region['nome']] : null,
                'estado' => $state ? ['id' => $state['id'], 'sigla' => $state['sigla'] ?? null, 'nome' => $state['nome']] : null,
                'municipio' => $city ? ['id' => $city['id'], 'nome' => $city['nome']] : null,
            ],
        ]);

        $this->closeEditModal();

        $this->event = Event::withCount('teams')->find($this->eventId);
        $this->banner('Evento atualizado com sucesso!');
    }

    public function openDeleteModal(): void
    {
        $this->authorize('delete');
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
    }

    public function deleteEvent()
    {
        $this->authorize('delete');

        if ($this->event) {
            $this->event->delete();
        }

        $this->banner('Evento apagado com sucesso!');
        return redirect()->route('tbr.dashboard');
    }

    public function render()
    {
        return view('livewire.page.tbr-event-detail', [
            'event' => $this->event,
            'regions' => $this->regions,
            'filteredEditStates' => $this->filteredEditStates,
            'filteredEditCities' => $this->filteredEditCities,
        ])->layout('layouts.app-sidebar', [
            'showSidebar' => true,
            'title' => $this->title,
        ]);
    }
}
