<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Support\Facades\Log;

class TbrScore extends Component
{
    use InteractsWithBanner;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $title = 'TBR - Notas';

    public $event_id;
    public $category_id;
    public $modality_id;

    public $questionLevel;
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
    public $showSidebar = true;

    public function mount($event_id, $category_id, $modality_id)
    {
        $this->event_id = $event_id;
        $this->category_id = $category_id;
        $this->modality_id = $modality_id;

        $this->loadEvent();
        $this->setQuestionLevelFromCategoryId($category_id);
        $this->loadCategory();
        $this->loadModality();
        $this->filterTeams();
        $this->loadQuestion();
        $this->calculateScorePerQuestion();
        $this->showSidebar = false;
    }

    private function loadEvent()
    {
        $jsonPath = 'tbr/json/data.json';
        if (Storage::disk('public')->exists($jsonPath)) {
            $events = json_decode(Storage::disk('public')->get($jsonPath), true) ?? [];
            $this->event = collect($events)->firstWhere('id', $this->event_id);
            Log::debug('loadEvent', ['event' => $this->event]);
        } else {
            Log::warning('Arquivo JSON do evento não encontrado.');
        }
    }

    private function setQuestionLevelFromCategoryId($category_id)
    {
        $category = collect(config('tbr-config.categories'))
            ->firstWhere('id', $category_id);

        $this->questionLevel = $category['question'] ?? 'basic';
    }

    private function loadCategory()
    {
        $categories = config('tbr-config.categories');
        $this->category = collect($categories)->firstWhere('id', $this->category_id);
    }

    private function loadModality()
    {
        if (!$this->category) return;

        $modalitieLevel = $this->category['modalitie'] ?? 'basic';
        $modalities = config("tbr-config.modalities_by_level.$modalitieLevel") ?? [];
        $this->modality = collect($modalities)->firstWhere('id', $this->modality_id);
    }

    private function loadQuestion()
    {
        if (!$this->category || !$this->modality) {
            $this->question = null;
            $this->hasAssessment = false;
            return;
        }

        $questionModalitie = $this->category['question'] ?? 'basic';
        $questions = config("tbr-config.questions_by_level.$questionModalitie", []);

        // Buscar pelo ID da modalidade
        $this->question = collect($questions)->firstWhere('id', $this->modality_id);

        if (!$this->question) {
            Log::warning("Pergunta não encontrada para modalidade_id={$this->modality_id} na configuração de {$questionModalitie}");
            $this->hasAssessment = false;
            return;
        }

        $this->hasAssessment = collect($this->question['assessment'] ?? [])
            ->filter(fn($item) => !empty($item['description']))
            ->isNotEmpty();

        $this->scores = [];

        if ($this->hasAssessment) {
            foreach ($this->question['assessment'] as $block) {
                $blockObject = $block['object'] ?? null;
                if ($blockObject && !empty($block['description'])) {
                    foreach ($block['description'] as $index => $desc) {
                        $this->scores[$blockObject][$index] = "5";
                    }
                }
            }
        }

        // dd($this->hasAssessment, $this->question);
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

        $modalitieLevel = $this->category['modalitie'] ?? 'basic';

        $modalitiesConfig = config("tbr-config.modalities_by_level.$modalitieLevel") ?? [];

        $modality = collect($modalitiesConfig)->firstWhere('id', $this->modality_id)
            ?? collect($modalitiesConfig)->firstWhere('slug', $this->modality_id);

        $modalitySlug = $modality['slug'] ?? null;

        if (!$categorySlug || !$modalitySlug) {
            $this->filteredTeams = [];
            return;
        }

        $this->filteredTeams = collect($this->event['equipes'] ?? [])
            ->filter(function ($team) use ($categorySlug, $modalitySlug, $modalitieLevel) {
                if ($team['category'] !== $categorySlug) return false;

                $modalities = $team['modalities'] ?? [];

                if (!array_key_exists($modalitySlug, $modalities)) return false;

                $nota = $modalities[$modalitySlug]['nota'] ?? [];

                // Se for nível 'basic', mostra sempre que a modalidade existir
                if ($modalitieLevel === 'basic') {
                    return true;
                }

                // Se for modalidade 'dp' (com blocos r1, r2, r3), verifica se todos estão vazios
                if ($modalitySlug === 'dp') {
                    if (!is_array($nota)) return false;
                    foreach ($nota as $bloco) {
                        if (!empty($bloco)) {
                            return false; // Já foi avaliado em algum bloco
                        }
                    }
                    return true;
                }

                // Para modalidades normais: mc, om, te, ap
                return empty($nota);
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
            $this->dangerBanner('Selecione uma equipe antes de salvar.');
            return;
        }

        $modalitieLevel = $this->category['modalitie'] ?? 'basic';

        $modalitiesConfig = config("tbr-config.modalities_by_level.$modalitieLevel") ?? [];

        $modality = collect($modalitiesConfig)->firstWhere('id', $this->modality_id);
        if (!$modality) {
            $modality = collect($modalitiesConfig)->firstWhere('slug', $this->modality_id);
        }
        $modalitySlug = $modality['slug'] ?? null;

        if (!$modalitySlug) {
            $this->warningBanner('Modalidade inválida.');
            return;
        }


        $this->calculateScorePerQuestion();

        // Carregar o JSON atual do disco para manter dados anteriores intactos
        $jsonData = Storage::disk('public')->exists('tbr/json/data.json')
            ? json_decode(Storage::disk('public')->get('tbr/json/data.json'), true)
            : [];

        // Assumindo que o evento que você quer atualizar é o primeiro do array, por exemplo
        if (empty($jsonData)) {
            $this->dangerBanner('Evento não encontrado no arquivo JSON.');
            return;
        }

        // Atualiza a equipe dentro do evento no JSON carregado
        foreach ($jsonData as &$event) {
            if ($event['id'] === $this->event['id']) { // Confirme que o id bate
                foreach ($event['equipes'] as &$team) {
                    if ($team['id'] === $this->selectedTeamId) {

                        // Certifique-se que existe o array 'modalities' e a modalidade atual
                        if (!isset($team['modalities'][$modalitySlug])) {
                            $team['modalities'][$modalitySlug] = [
                                'nota' => [],
                                'total' => 0,
                                'comentario' => ''
                            ];
                        }

                        // Atualiza somente a modalidade específica, preservando as outras
                        $team['modalities'][$modalitySlug]['nota'] = [];

                        foreach ($this->scores as $blockObject => $indices) {
                            foreach ($indices as $index => $value) {
                                $team['modalities'][$modalitySlug]['nota'][] = (string) $value;
                            }
                        }

                        $team['modalities'][$modalitySlug]['comentario'] = $this->comment;

                        $sumTotal = array_sum(array_map('intval', $team['modalities'][$modalitySlug]['nota']));

                        if ($this->questionLevel === 'basic') {
                            // Soma direta dos valores para nível básico
                            $team['modalities'][$modalitySlug]['total'] = number_format($sumTotal, 2, '.', '');
                        } else {
                            // Aplica multiplicador por questão para nível advanced
                            $totalCalculado = $this->scorePerQuestion * $sumTotal;
                            $team['modalities'][$modalitySlug]['total'] = number_format($totalCalculado, 2, '.', '');
                        }

                        // Recalcula a nota total da equipe somando todas as modalidades
                        $notaTotal = 0;
                        foreach ($team['modalities'] as $mod) {
                            $notaTotal += floatval($mod['total'] ?? 0);
                        }
                        $team['nota_total'] = number_format($notaTotal, 2, '.', '');

                        break;
                    }
                }
                unset($team);

                break;
            }
        }
        unset($event);

        // Salva o JSON atualizado mantendo tudo
        Storage::disk('public')->put('tbr/json/data.json', json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->selectedTeamId = null;
        $this->loadEvent();
        $this->filterTeams();

        $this->resetValidation();
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
        ])->layout('layouts.app-sidebar', [
            'showSidebar' => $this->showSidebar,
            'title' => $this->title
        ]);
    }
}
