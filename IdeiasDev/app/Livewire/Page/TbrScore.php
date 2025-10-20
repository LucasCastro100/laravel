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
    public $modalitieSlug;

    public $question = null;

    public $hasAssessment = false;
    private $totalQuestions = 0;
    public $scorePerQuestion = 0;

    public $filteredTeams = [];
    public $selectedTeamId = null;

    public $scores = [];
    public $comment = "";
    public $bonus = "nao";
    public $showSidebar = true;

    // aqui apra multiplicar notas das missoes no dp  
    public $blocks = [];
    public $scoresDP = [];
    public $missions = [];
    public $dp_pontos = 0;

    // MODAL PARA RECARREGAR A APGINA
    public $showSuccessModal = false;

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

        // Exemplo, adapte conforme sua estrutura de $blocks/missions
        foreach ($this->blocks as $blockMission => $block) {
            foreach ($block['itens'] as $index => $item) {
                if (!isset($this->scores[$blockMission][$index])) {
                    $this->scores[$blockMission][$index] = '0';
                }
            }
        }
    }

    private function loadEvent()
    {
        $jsonPath = 'tbr/json/data.json';
        if (Storage::disk('public')->exists($jsonPath)) {
            $events = json_decode(Storage::disk('public')->get($jsonPath), true) ?? [];
            $this->event = collect($events)->firstWhere('id', $this->event_id);
            // Log::debug('loadEvent', ['event' => $this->event]);
        } else {
            // Log::warning('Arquivo JSON do evento não encontrado.');
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

        $this->modalitieSlug = $this->modality['slug'];

        if ($this->modalitieSlug == 'dp') {
            $questionModalitie = $this->category['dp'] ?? null;
            $questions = config("tbr-config.dp_by_level.$questionModalitie", []);
            $this->scores = [];

            $this->question = $questions;
            $this->hasAssessment = collect($questions)->isNotEmpty();
        } else {
            $questionModalitie = $this->category['question'] ?? 'basic';
            $questions = config("tbr-config.questions_by_level.$questionModalitie", []);

            // Buscar pelo ID da modalidade
            $this->question = collect($questions)->firstWhere('id', $this->modality_id);

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

                if ($modalitieLevel === 'basic') {
                    return true;
                }

                if ($modalitySlug === 'dp') {
                    if (!is_array($nota)) return false;

                    $requiredRounds = ['r1', 'r2', 'r3'];

                    // Verifica se todos os rounds estão presentes e preenchidos
                    $allFilled = collect($requiredRounds)->every(function ($round) use ($nota) {
                        if (!isset($nota[$round]) || !is_array($nota[$round])) {
                            return false; // round não existe ou não é array → considerar vazio
                        }
                        return !empty($nota[$round]); // round deve estar preenchido (não vazio)
                    });

                    return !$allFilled;
                }

                return empty($nota);
            })
            ->values()
            ->all();
    }

    public function getSelectedTeamProperty()
    {
        return collect($this->filteredTeams)->firstWhere('id', $this->selectedTeamId);
    }

    private function getModalitiesConfig($slug)
    {
        if ($slug === 'dp') {
            $modalitieLevel = $this->category['dp'];
            return config("tbr-config.dp_by_level.$modalitieLevel") ?? [];
        } else {
            $modalitieLevel = $this->category['modalitie'] ?? 'basic';
            return config("tbr-config.modalities_by_level.$modalitieLevel") ?? [];
        }
    }

    public function updateScoreDPManual($value, $name)
    {
        $this->updatedScoresDP($value, $name);
    }

    public function updatedScoresDP($value, $name)
    {
        $modalitieLevel = $this->category['dp'] ?? null;
        $dp_level = config("tbr-config.dp_by_level.$modalitieLevel") ?? [];

        $parts = explode('.', $name);
        if (count($parts) !== 2) {
            return;
        }

        [$missionIndex, $itemIndex] = array_map('intval', $parts);

        $mission = $dp_level[$missionIndex] ?? null;
        if (!$mission) {
            return;
        }

        if (($mission['type'] ?? null) === 'number' && is_numeric($value)) {
            $itemFactor = isset($mission['itens'][$itemIndex]['value'])
                ? (float) $mission['itens'][$itemIndex]['value']
                : 1;

            $calcValue = $value * $itemFactor;

            // agora salva direto no scores
            $this->scores[$missionIndex][$itemIndex] = $calcValue;
        }

        $this->dp_pontos = 0;

        foreach ($this->scores as $mIndex => $missionValues) {
            $missionBonus = $dp_level[$mIndex]['bonus'] ?? 0;
            $sumMissionValues = array_sum($missionValues);

            if ($this->bonus === 'sim' && is_numeric($missionBonus)) {
                $sumMissionValues += $missionBonus;
            }

            $this->dp_pontos += $sumMissionValues;
        }
    }

    private function flattenScores(array $scores, array $dp_level): array
    {
        $result = [];

        foreach ($scores as $missionIndex => $items) {
            $sum = 0;

            if (is_array($items)) {
                foreach ($items as $value) {
                    $sum += (int) $value;
                }
            } else {
                $sum = (int) $items;
            }

            // aplica bônus só se $this->bonus for "sim"
            if ($this->bonus === 'sim') {
                $missionBonus = $dp_level[$missionIndex]['bonus'] ?? 0;
                if (is_numeric($missionBonus)) {
                    $sum += (int) $missionBonus;
                }
            }

            $result[] = $sum;
        }

        return $result;
    }

    private function saveScorePracticalChallenge(array &$team)
    {
        $modalitySlug = 'dp';
        $modalitieLevel = $this->category[$modalitySlug];
        $dp_categorie = config("tbr-config.dp_by_level.$modalitieLevel") ?? [];

        $flattenedScores = $this->flattenScores($this->scores ?? [], $dp_categorie);

        if (!isset($team['modalities'][$modalitySlug])) {
            $team['modalities'][$modalitySlug] = [
                'nota' => [
                    'r1' => [],
                    'r2' => [],
                    'r3' => []
                ],
                'total' => 0,
                'comentario' => ''
            ];
        }

        // salva no primeiro round vazio
        foreach (['r1', 'r2', 'r3'] as $round) {
            if (empty($team['modalities'][$modalitySlug]['nota'][$round])) {
                $team['modalities'][$modalitySlug]['nota'][$round] = $flattenedScores;
                break;
            }
        }

        // calcula total como o maior round
        $totals = [];
        foreach ($team['modalities'][$modalitySlug]['nota'] as $roundValues) {
            $totals[] = array_sum($roundValues);
        }
        $team['modalities'][$modalitySlug]['total'] = max($totals);

        $team['modalities'][$modalitySlug]['comentario'] = $this->comment ?? '';
    }

    private function saveScoreOtherModalities(array &$team, string $modalitySlug)
    {

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
    }

    private function validateScores()
    {
        $modalitySlug = $this->modality['slug'];
        
        // Verifica se equipe foi selecionada
        if (!$this->selectedTeamId) {
            $this->dangerBanner('Selecione uma equipe antes de salvar.');
            return false;
        }

        // Verifica se algum score foi enviado (para radio)
        if (empty($this->scores) && empty($this->scoresDP)) {
            $this->dangerBanner('Você precisa responder todas as perguntas.');
            return false;
        }

        // Inicializa o bônus como 'nao'
        $this->bonus = 'nao';


        if ($modalitySlug === 'dp') {
            foreach ($this->question ?? [] as $index => $question) {
                $type = $question['type'] ?? 'radio';
                $description = $question['description'] ?? "Pergunta {$index}";

                if ($type === 'radio') {
                    // Para radio, pega o valor em scores
                    $value = $this->scores[$index] ?? null;
                    if ($value === null || $value === '') {
                        $this->dangerBanner("Você precisa selecionar uma opção para a pergunta '{$description}'.");
                        return false;
                    }
                } elseif ($type === 'number') {
                    // Para number, pega valores do scoresDP
                    $values = $this->scoresDP[$index] ?? null;

                    if (!is_array($values) || empty($values)) {
                        $this->dangerBanner("Você precisa preencher a pergunta '{$description}'.");
                        return false;
                    }

                    $sumValues = 0;

                    foreach ($values as $itemIndex => $value) {
                        if ($value === null || $value === '') {
                            $this->dangerBanner("Você precisa preencher o item #{$itemIndex} da pergunta '{$description}'.");
                            return false;
                        }

                        // Verifica se é inteiro (pode ajustar para float se quiser)
                        if (!is_numeric($value) || intval($value) != $value) {
                            $this->dangerBanner("O valor do item #{$itemIndex} da pergunta '{$description}' deve ser um número inteiro.");
                            return false;
                        }

                        $intValue = intval($value);

                        if ($intValue < 0 || $intValue > 10) {
                            $this->dangerBanner("O valor do item #{$itemIndex} da pergunta '{$description}' deve estar entre 0 e 10.");
                            return false;
                        }

                        $sumValues += $intValue;
                    }

                    if ($sumValues > 10) {
                        $this->dangerBanner("A soma dos valores da pergunta '{$description}' não pode ser maior que 10. Atualmente está {$sumValues}.");
                        return false;
                    }

                    if ($sumValues === 10) {
                        $this->bonus = 'sim';
                    }
                }
            }
        }

        return true;
    }


    public function saveScores()
    {
        if (!$this->validateScores()) {
            return;
        }

        $modalitySlug = $this->modality['slug'];
        $modalitiesConfig = $this->getModalitiesConfig($modalitySlug);

        $modality = collect($modalitiesConfig)->firstWhere('id', $this->modality_id);
        if (!$modality) {
            $modality = collect($modalitiesConfig)->firstWhere('slug', $this->modality_id);
        }

        if (!$modalitySlug) {
            $this->warningBanner('Modalidade inválida.');
            return;
        }

        $this->calculateScorePerQuestion();

        ksort($this->scores);

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
                        if ($modalitySlug === 'dp') {
                            $this->saveScorePracticalChallenge($team);
                        } else {
                            $this->saveScoreOtherModalities($team, $modalitySlug);
                        }

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

        $this->showSuccessModal = true;
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
            'modalitieSlug' => $this->modalitieSlug
        ])->layout('layouts.app-sidebar', [
            'showSidebar' => $this->showSidebar,
            'title' => $this->title
        ]);
    }
}
