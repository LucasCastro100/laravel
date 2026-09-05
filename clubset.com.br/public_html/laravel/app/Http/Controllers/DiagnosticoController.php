<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticoResposta;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class DiagnosticoController extends Controller
{
    /**
     * Show the diagnostic form.
     */
    public function index(): Response
    {
        $states = State::query()->orderBy('name')->get(['id', 'name', 'uf', 'region']);
        $regions = $states->pluck('region')->unique()->sort()->values()->all();

        return Inertia::render('diagnostico/index', [
            'areas' => config('diagnosticoQuestions'),
            'listaRendas' => DiagnosticoResposta::RENDAS,
            'states' => $states,
            'regions' => $regions,
        ]);
    }

    /**
     * Store the diagnostic answers and redirect to the result page.
     */
    public function store(Request $request): RedirectResponse
    {
        $areas = config('diagnosticoQuestions');

        $perguntas = collect($areas)
            ->flatMap(fn (array $area) => $area['perguntas'])
            ->keyBy('id');

        $dados = $request->validate([
            'renda' => ['required', 'string', Rule::in(DiagnosticoResposta::RENDAS)],
            'nome' => ['required', 'string', 'max:255'],
            'instagram' => ['required', 'string', 'max:255'],
            'celular' => ['required', 'string', 'max:30'],
            'state_id' => ['required', 'integer', 'exists:states,id'],
            'municipality_id' => ['required', 'integer', 'exists:municipalities,id'],
            'participa_grupo_whatsapp' => ['required', 'boolean'],
            'grupo_whatsapp_qual' => ['sometimes', 'nullable', 'string', 'max:255'],
            'respostas' => ['required', 'array', 'size:'.count($perguntas)],
            'respostas.*.letra' => ['required', 'string', 'size:1'],
        ]);

        $respostas = [];
        foreach ($dados['respostas'] as $perguntaId => $resposta) {
            $letra = $resposta['letra'];
            $alterativa = collect($perguntas[$perguntaId]['alternativas'])
                ->firstWhere('letra', $letra);

            if ($alterativa === null) {
                return back()->withErrors(['respostas.'.$perguntaId => 'Alternativa inválida.']);
            }

            $respostas[$perguntaId] = [
                'letra' => $letra,
                'pontos' => $alterativa['pontos'],
            ];
        }

        $grupoQual = filter_var($dados['participa_grupo_whatsapp'], FILTER_VALIDATE_BOOL)
            ? $request->validate(['grupo_whatsapp_qual' => ['required', 'string', 'max:255']])['grupo_whatsapp_qual']
            : null;

        $resultado = $this->calcularResultado($areas, $respostas);

        $registro = DiagnosticoResposta::create([
            'renda' => $dados['renda'],
            'nome' => $dados['nome'],
            'instagram' => $dados['instagram'],
            'celular' => $dados['celular'],
            'state_id' => $dados['state_id'],
            'municipality_id' => $dados['municipality_id'],
            'participa_grupo_whatsapp' => $dados['participa_grupo_whatsapp'],
            'grupo_whatsapp_qual' => $grupoQual,
            'respostas' => $respostas,
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

        $resultado = $registro->resultadoComTextos($registro->resultado);
        $resultado['criticos'] = array_slice($resultado['criticos'] ?? [], 0, 2);

        return Inertia::render('diagnostico/resultado', [
            'areas' => config('diagnosticoQuestions'),
            'respostas' => $registro->respostas,
            'resultado' => $resultado,
            'liberado' => $registro->resultado_liberado_em !== null,
            'pix' => config('diagnosticoPix'),
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
