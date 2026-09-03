<?php

namespace App\Models;

use Database\Factories\DiagnosticoRespostaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property array<int|string, mixed> $respostas
 * @property array<string, mixed> $resultado
 */
#[Fillable([
    'uuid',
    'respostas',
    'resultado',
])]
class DiagnosticoResposta extends Model
{
    /** @use HasFactory<DiagnosticoRespostaFactory> */
    use HasFactory, HasUuids;

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'respostas' => 'array',
            'resultado' => 'array',
        ];
    }
}
