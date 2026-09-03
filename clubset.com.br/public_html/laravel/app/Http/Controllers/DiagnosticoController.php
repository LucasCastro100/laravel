<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticoResposta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DiagnosticoController extends Controller
{
    /**
     * Show the diagnostic form.
     */
    public function index(): Response
    {
        return Inertia::render('diagnostico/index', [
            'areas' => config('diagnosticoQuestions'),
        ]);
    }

    /**
     * Store the diagnostic answers and redirect to the result page.
     */
    public function store(Request $request): RedirectResponse
    {
        $areas = config('diagnosticoQuestions');

        $respostas = $request->input('respostas');

        $perguntaIds = collect($areas)
            ->flatMap(fn (array $area) => $area['perguntas'])
            ->pluck('id')
            ->all();

        $dados = $request->validate([
            'respostas' => ['required', 'array', 'size:'.count($perguntaIds)],
            'respostas.*.letra' => ['required', 'string', 'max:1'],
            'respostas.*.pontos' => ['required', 'integer', 'between:0,3'],
        ]);

        $resultado = $this->calcularResultado($areas, $dados['respostas']);

        $registro = DiagnosticoResposta::create([
            'respostas' => $dados['respostas'],
            'resultado' => $resultado,
        ]);

        return to_route('diagnostico.resultado', $registro->uuid);
    }

    /**
     * Show the diagnostic result for a given submission.
     */
    public function resultado(string $uuid): Response
    {
        $registro = DiagnosticoResposta::where('uuid', $uuid)->firstOrFail();

        $resultado = $registro->resultado;
        $resultado['criticos'] = array_slice($resultado['criticos'] ?? [], 0, 2);

        return Inertia::render('diagnostico/resultado', [
            'areas' => config('diagnosticoQuestions'),
            'respostas' => $registro->respostas,
            'resultado' => $resultado,
        ]);
    }

    /**
     * Calculate the per-area scores, overall score and critical areas.
     *
     * @param  list<array{area: string, area_key: string, perguntas: list<array{id: string, text: string, alternativas: list<array{letra: string, text: string, pontos: int}>}>}>  $areas
     * @param  array<string, array{letra: string, pontos: int}>  $respostas
     * @return array<string, mixed>
     */
    private function calcularResultado(array $areas, array $respostas): array
    {
        $areasResultado = [];

        foreach ($areas as $area) {
            $pontos = collect($area['perguntas'])
                ->sum(fn (array $pergunta) => $respostas[$pergunta['id']]['pontos'] ?? 0);

            $normalizado = (int) round(($pontos / 12) * 100);

            $areasResultado[] = [
                'area' => $area['area'],
                'area_key' => $area['area_key'],
                'pontos' => $pontos,
                'normalizado' => $normalizado,
                'faixa' => $this->faixa($normalizado),
                'faixa_label' => $this->faixaLabel($normalizado),
            ];
        }

        $geral = empty($areasResultado)
            ? 0
            : (int) round(collect($areasResultado)->avg('normalizado'));

        $criticos = collect($areasResultado)
            ->sortBy('normalizado')
            ->take(2)
            ->values();

        return [
            'geral' => $geral,
            'faixa_geral' => $this->faixa($geral),
            'faixa_geral_label' => $this->faixaLabel($geral),
            'areas' => $areasResultado,
            'criticos' => $criticos,
        ];
    }

    /**
     * Trigger the score band (critico/construcao/solido) from a 0-100 value.
     */
    private function faixa(int $normalizado): string
    {
        if ($normalizado <= 40) {
            return 'critico';
        }

        if ($normalizado <= 70) {
            return 'construcao';
        }

        return 'solido';
    }

    /**
     * Human readable label for a 0-100 score band.
     */
    private function faixaLabel(int $normalizado): string
    {
        if ($normalizado <= 40) {
            return 'Crítico';
        }

        if ($normalizado <= 70) {
            return 'Em construção';
        }

        return 'Sólido';
    }
}
