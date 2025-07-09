<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class TbrScore extends Component
{
    public $event_id;
    public $category_id;
    public $modality_id;

    public $event;
    public $category;
    public $modality;

    /**
     * Inicializa o componente e carrega dados de evento, categoria e modalidade.
     *
     * @param string $event_id
     * @param string $category_id
     * @param string $modality_id
     */
    public function mount($event_id, $category_id, $modality_id)
    {
        $this->event_id = $event_id;
        $this->category_id = $category_id;
        $this->modality_id = $modality_id;

        // Carrega lista de eventos e seleciona o evento atual
        $jsonPath = 'tbr/data.json';
        if (Storage::disk('public')->exists($jsonPath)) {
            $events = json_decode(Storage::disk('public')->get($jsonPath), true) ?? [];
            $this->event = collect($events)->firstWhere('id', $this->event_id);
        }

        // Carrega dados da categoria a partir da configuração
        $categories = config('data-tbr.categories');
        $this->category = collect($categories)->firstWhere('id', $this->category_id);

        // Carrega dados da modalidade a partir da configuração
        $modalities = config('data-tbr.modalities');
        $this->modality = collect($modalities)->firstWhere('id', $this->modality_id);
    }

    /**
     * Renderiza a view de pontuação, passando evento, categoria e modalidade.
     */
    public function render()
    {
        return view('livewire.page.tbr-score', [
            'event' => $this->event,
            'category' => $this->category,
            'modality' => $this->modality,
        ])->layout('layouts.app-sidebar');
    }
}
