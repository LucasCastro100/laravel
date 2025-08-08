<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;

class TbrLinks extends Component
{
    use InteractsWithBanner;

    public $title = 'TBR - Links';
    public $showSidebar = false;

    public $event_id;
    public $event;

    // Guarda categorias filtradas junto com suas modalidades
    public array $categoriesWithModalities = [];

    /**
     * Inicializa o componente, carregando o evento e as categorias com modalidades.
     */
    public function mount($event_id)
    {
        $this->event_id = $event_id;
        $this->loadEvent();
        $this->categoriesWithModalities = $this->loadCategoriesAndModalities();
    }

    /**
     * Carrega os dados do evento a partir do JSON, buscando pelo ID informado.
     * Se o arquivo não existir, exibe um banner de erro.
     */
    private function loadEvent()
    {
        $jsonPath = 'tbr/json/data.json';

        if (Storage::disk('public')->exists($jsonPath)) {
            $events = json_decode(Storage::disk('public')->get($jsonPath), true) ?? [];
            $this->event = collect($events)->firstWhere('id', $this->event_id);
        } else {
            $this->dangerBanner('Arquivo não encontrado');
        }
    }

    /**
     * Retorna um array com o nome do evento e as categorias com suas modalidades,
     * filtrando somente as categorias das equipes presentes no evento.
     */
    public function loadCategoriesAndModalities()
    {
        $teams = $this->event['equipes'] ?? [];

        // Obtém slugs únicos das categorias das equipes
        $categorySlugs = $this->getUniqueCategorySlugs($teams);

        // Filtra as categorias configuradas que correspondem aos slugs do evento
        $filteredCategories = $this->getFilteredCategories($categorySlugs);

        // Formata as categorias com as modalidades
        $categoriesWithModalities = $this->formatCategoriesWithModalities($filteredCategories);

        return [
            'event_id' => $this->event['id'],
            'event' => $this->event['nome'],            
            'links' => $categoriesWithModalities,
        ];
    }

    /**
     * Retorna os slugs únicos das categorias encontradas nas equipes do evento.
     */
    private function getUniqueCategorySlugs(array $teams)
    {
        return collect($teams)
            ->pluck('category')
            ->unique()
            ->values();
    }

    /**
     * Filtra as categorias da configuração para retornar somente as que possuem slug no array dado.
     */
    private function getFilteredCategories($categorySlugs)
    {
        $configCategories = collect(config('tbr-config.categories'));

        return $configCategories->filter(function ($category) use ($categorySlugs) {
            return $categorySlugs->contains($category['slug']);
        })->values();
    }

    /**
     * Formata as categorias filtradas adicionando as modalidades correspondentes
     * baseadas no nível da categoria.
     */
    private function formatCategoriesWithModalities($filteredCategories)
    {
        $modalitiesByLevel = config('tbr-config.modalities_by_level');

        return $filteredCategories->map(function ($category) use ($modalitiesByLevel) {
            $level = $category['modalitie'] ?? null;

            $modalities = $level && isset($modalitiesByLevel[$level])
                ? $modalitiesByLevel[$level]
                : [];

            $modalitiesFormatted = collect($modalities)->map(function ($modality) {
                return [
                    'id' => $modality['id'],
                    'name' => $modality['label'],
                ];
            })->values()->toArray();

            return [
                'category_name' => $category['label'],
                'category_id' => $category['id'],
                'modalities' => $modalitiesFormatted,
            ];
        })->values()->toArray();
    }

    /**
     * Renderiza a view com as categorias e modalidades já carregadas.
     */
    public function render()
    {
        return view('livewire.page.tbr-links', [
            'categoriesWithModalities' => $this->categoriesWithModalities,
        ])->layout('layouts.app-sidebar', [
            'showSidebar' => $this->showSidebar,
            'title' => $this->title,
        ]);
    }
}
