<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class TbrRanking extends Component
{
    public $event_id;
    public array $event = [];
    public array $teamsByCategory = [];

    public function mount($event_id)
    {
        $this->event_id = $event_id;
        $this->loadEvent($event_id);
        $this->organizeTeamsByCategory();
    }

    public function loadEvent($id): void
    {
        $jsonPath = 'tbr/json/data.json';

        if (Storage::disk('public')->exists($jsonPath)) {
            $json = Storage::disk('public')->get($jsonPath);
            $events = json_decode($json, true) ?? [];

            $this->event = collect($events)->firstWhere('id', $id) ?? [];
        }
    }

    private function calculateModalityScore(array $modalidades = [], string $modalitySlug): float
    {
        if (!isset($modalidades[$modalitySlug]['nota'])) return 0;

        $nota = $modalidades[$modalitySlug]['nota'];

        if ($modalitySlug === 'dp') {
            $maxSum = 0;
            foreach (['r1', 'r2', 'r3'] as $r) {
                if (isset($nota[$r]) && is_array($nota[$r])) {
                    $sum = array_sum(array_map('floatval', $nota[$r]));
                    if ($sum > $maxSum) $maxSum = $sum;
                }
            }
            return $maxSum;
        }

        return is_array($nota) ? array_sum(array_map('floatval', $nota)) : floatval($nota);
    }

    public function organizeTeamsByCategory(): void
    {
        $teams = collect($this->event['equipes'] ?? []);
        $categories = collect(config('tbr-config.categories'));
        $modalitiesByLevel = config('tbr-config.modalities_by_level');

        $this->teamsByCategory = [];

        foreach ($categories as $category) {
            $slug = $category['slug'];
            $modalitie_level = $category['modalitie'] ?? 'basic';
            $modalities = collect($modalitiesByLevel[$modalitie_level] ?? []);

            $this->teamsByCategory[$slug] = [
                'label' => $category['label'],
                'modalities' => [],            // times por modalidade
                'modalities_data' => $modalities->toArray(),  // modalidades para o Blade
                'total' => [],
            ];

            $teamsInCategory = $teams->filter(fn($team) => ($team['category'] ?? null) === $slug);

            foreach ($modalities as $modality) {
                $modSlug = $modality['slug'];
                $this->teamsByCategory[$slug]['modalities'][$modSlug] = $teamsInCategory
                    ->map(fn($team) => [
                        'id' => $team['id'],
                        'name' => $team['name'],
                        'score' => isset($team['modalities'][$modSlug]['total']) ? floatval($team['modalities'][$modSlug]['total']) : 0,
                    ])
                    ->sortByDesc('score')
                    ->values()
                    ->toArray();
            }

            $this->teamsByCategory[$slug]['total'] = $teamsInCategory
                ->map(fn($team) => [
                    'id' => $team['id'],
                    'name' => $team['name'],
                    'total' => isset($team['nota_total']) ? floatval($team['nota_total']) : 0,
                ])
                ->sortByDesc('total')
                ->values()
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.page.tbr-ranking', [
            'event' => $this->event,
            'teamsByCategory' => $this->teamsByCategory,
        ])->layout('layouts.app-sidebar');
    }
}
