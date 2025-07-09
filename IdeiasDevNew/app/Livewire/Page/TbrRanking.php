<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class TbrRanking extends Component
{
    public $event_id;
    public $event;

    /**
     * Monta o componente inicializando o evento com base no ID fornecido.
     * Carrega os eventos do JSON e busca o evento correspondente.
     *
     * @param string $event_id
     */
    public function mount($event_id)
    {
        $this->event_id = $event_id;

        $jsonPath = 'tbr/data.json';
        if (Storage::disk('public')->exists($jsonPath)) {
            $json = Storage::disk('public')->get($jsonPath);
            $events = json_decode($json, true) ?? [];

            $this->event = collect($events)->firstWhere('id', $this->event_id);
        }
    }

    /**
     * Renderiza a view de ranking, passando o evento carregado.
     */
    public function render()
    {
        return view('livewire.page.tbr-ranking', [
            'event' => $this->event,
        ])->layout('layouts.app-sidebar');
    }
}
