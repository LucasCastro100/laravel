<?php

namespace App\Models;

use Database\Factories\DiagnosticoRespostaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $uuid
 * @property string $renda
 * @property array<int|string, mixed> $respostas
 * @property array<string, mixed> $resultado
 * @property Carbon|null $resultado_liberado_em
 */
#[Fillable([
    'uuid',
    'nome',
    'instagram',
    'celular',
    'state_id',
    'municipality_id',
    'participa_grupo_whatsapp',
    'grupo_whatsapp_qual',
    'renda',
    'respostas',
    'resultado',
    'resultado_liberado_em',
])]
class DiagnosticoResposta extends Model
{
    /** @use HasFactory<DiagnosticoRespostaFactory> */
    use HasFactory, HasUuids;

    /**
     * The income ranges available in the diagnostic.
     *
     * @var list<string>
     */
    public const RENDAS = [
        'De 1.000 a 2.000',
        'Até 5.000',
        'Acima de 5.000',
        'Mais de 10.000',
    ];

    /**
     * The columns that should receive a generated UUID.
     *
     * @return list<string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    /**
     * The Brazilian state the respondent belongs to.
     *
     * @return BelongsTo<State, $this>
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * The municipality the respondent belongs to.
     *
     * @return BelongsTo<Municipality, $this>
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'participa_grupo_whatsapp' => 'boolean',
            'respostas' => 'array',
            'resultado' => 'array',
            'resultado_liberado_em' => 'datetime',
        ];
    }

    /**
     * Attach the explanatory text of each area's score band.
     *
     * @param  array<string, mixed>  $resultado
     * @return array<string, mixed>
     */
    public function resultadoComTextos(array $resultado): array
    {
        $textos = collect(config('diagnosticoQuestions'))
            ->mapWithKeys(fn (array $area): array => [$area['area_key'] => $area['textos'] ?? []])
            ->all();

        $resultado['areas'] = collect($resultado['areas'] ?? [])
            ->map(function (array $area) use ($textos): array {
                $area['texto'] = $textos[$area['area_key']][$area['faixa']] ?? '';

                return $area;
            })
            ->all();

        return $resultado;
    }
}
