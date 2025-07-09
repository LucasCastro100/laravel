<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;

class TbrScore extends Component
{
    use InteractsWithBanner;

    public $event_id;
    public $category_id;
    public $modality_id;

    public $event;
    public $category;
    public $modality;

    public $question = null;

    public $hasAssessment = false;
    private $totalQuestions = 0;
    public $scorePerQuestion = 0;

    public $filteredTeams = [];
    public $selectedTeamId = null;

    public $scores = [];
    public $comment = "";

    public function mount($event_id, $category_id, $modality_id)
    {
        $this->event_id = $event_id;
        $this->category_id = $category_id;
        $this->modality_id = $modality_id;

        $this->loadEvent();
        $this->filterTeams();
        $this->loadCategory();
        $this->loadModality();
        $this->loadQuestion();
        $this->calculateScorePerQuestion();
    }

    private function loadEvent()
    {
        $jsonPath = 'tbr/json/data.json';

        if (Storage::disk('public')->exists($jsonPath)) {
            $events = json_decode(Storage::disk('public')->get($jsonPath), true) ?? [];
            $this->event = collect($events)->firstWhere('id', $this->event_id);
        }
    }

    private function loadCategory()
    {
        $categories = config('tbr-config.categories');
        $this->category = collect($categories)->firstWhere('id', $this->category_id);
    }

    private function loadModality()
    {
        $modalities = config('tbr-config.modalities');
        $this->modality = collect($modalities)->firstWhere('id', $this->modality_id);
    }

    private function loadQuestion()
    {
        if (!$this->category || !$this->modality) return;

        $questionType = $this->category['question'] ?? 'basic';
        $questions = config("tbr-config.questions.$questionType");
        $this->question = collect($questions)->firstWhere('id', $this->modality_id);

        $this->hasAssessment = collect($this->question['assessment'] ?? [])
            ->filter(fn($item) => !empty($item['description']))
            ->isNotEmpty();

        $this->scores = [];

        if ($this->question && $this->hasAssessment) {
            foreach ($this->question['assessment'] as $block) {
                $blockObject = $block['object'] ?? null;
                if ($blockObject && !empty($block['description'])) {
                    foreach ($block['description'] as $index => $desc) {
                        $this->scores[$blockObject][$index] = "5";
                    }
                }
            }
        }
    }

    private function calculateScorePerQuestion()
    {
        $this->totalQuestions = collect($this->question['assessment'] ?? [])
            ->sum(fn($block) => count($block['description'] ?? []));

        $this->scorePerQuestion = $this->totalQuestions > 0
            ? 500 / ($this->totalQuestions * 9)
            : 0;
    }

    private function filterTeams()
    {
        $categorySlug = collect(config('tbr-config.categories'))
            ->firstWhere('id', $this->category_id)['slug'] ?? null;

        $modalitySlug = collect(config('tbr-config.modalities'))
            ->firstWhere('id', $this->modality_id)['slug'] ?? null;

        if (!$categorySlug || !$modalitySlug) {
            $this->filteredTeams = [];
            return;
        }

        $this->filteredTeams = collect($this->event['equipes'] ?? [])
            ->filter(function ($team) use ($categorySlug, $modalitySlug) {
                if ($team['category'] !== $categorySlug) {
                    return false;
                }

                if (!array_key_exists($modalitySlug, $team['modalities'] ?? [])) {
                    return false;
                }

                $modalitiesBlock = ['mc', 'om', 'te'];

                if (in_array($modalitySlug, $modalitiesBlock)) {
                    return empty($team['modalities'][$modalitySlug]['nota'] ?? []);
                }

                if ($modalitySlug === 'dp') {
                    return true;
                }

                return false;
            })
            ->values()
            ->all();
    }

    public function getSelectedTeamProperty()
    {
        return collect($this->filteredTeams)->firstWhere('id', $this->selectedTeamId);
    }

    public function saveScores()
    {
        if (!$this->selectedTeamId) {
            session()->flash('error', 'Selecione uma equipe antes de salvar.');
            return;
        }

        $modalitySlug = collect(config('tbr-config.modalities'))
            ->firstWhere('id', $this->modality_id)['slug'] ?? null;

        if (!$modalitySlug) {
            session()->flash('error', 'Modalidade inválida.');
            return;
        }

        $this->calculateScorePerQuestion();

        foreach ($this->event['equipes'] as &$team) {
            if ($team['id'] === $this->selectedTeamId) {

                $team['modalities'][$modalitySlug]['nota'] = [];

                foreach ($this->scores as $blockObject => $indices) {
                    foreach ($indices as $index => $value) {
                        $team['modalities'][$modalitySlug]['nota'][] = (string) $value;
                    }
                }

                $team['modalities'][$modalitySlug]['comentario'] = $this->comment;

                $sumTotal = array_sum(array_map('intval', $team['modalities'][$modalitySlug]['nota']));
                $totalCalculado = $this->scorePerQuestion * $sumTotal;
                $team['modalities'][$modalitySlug]['total'] = number_format($totalCalculado, 2, '.', '');                

                break;
            }
        }
        unset($team);

        $jsonPath = 'tbr/json/data.json';
        Storage::disk('public')->put($jsonPath, json_encode([$this->event], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->filterTeams();

        $this->banner('Pontuação salva com sucesso!');

        $this->selectedTeamId = null;
        $this->scores = [];
        $this->comment = '';
        $this->loadQuestion();
    }

    public function render()
    {
        return view('livewire.page.tbr-score', [
            'event' => $this->event,
            'filteredTeams' => $this->filteredTeams,
            'category' => $this->category,
            'modality' => $this->modality,
            'question' => $this->question,
            'hasAssessment' => $this->hasAssessment,
        ])->layout('layouts.app-sidebar');
    }
}
