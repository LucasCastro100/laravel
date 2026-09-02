<?php

namespace App\Models;

use App\Enums\PermutaStatus;
use Database\Factories\PermutaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int|null $contato_id
 * @property string|null $contato_nome
 * @property string|null $titulo
 * @property string|null $descricao
 * @property float $valor
 * @property Carbon|null $data
 * @property PermutaStatus $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @property-read User|null $contato
 */
#[Fillable([
    'user_id',
    'contato_id',
    'contato_nome',
    'titulo',
    'descricao',
    'valor',
    'data',
    'status',
])]
#[Hidden([])]
class Permuta extends Model
{
    /** @use HasFactory<PermutaFactory> */
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Permuta $permuta) {
            $permuta->uuid ??= (string) Str::uuid();
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'data' => 'date',
            'status' => PermutaStatus::class,
        ];
    }

    /**
     * The user who created the permuta (recorded as profit/income).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The linked user who receives the permuta as an expense (nullable).
     */
    public function contato(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contato_id');
    }

    /**
     * The display name of the linked party (registered user or free-form).
     */
    protected function contatoLabel(): string
    {
        return $this->contato?->name ?? $this->contato_nome ?? 'Pessoa avulsa';
    }

    /**
     * Format the permuta value as a currency string.
     */
    protected function getFormattedValorAttribute(): string
    {
        return 'R$ '.number_format((float) $this->valor, 2, ',', '.');
    }

    /**
     * Whether the given user is the creator of this permuta.
     */
    public function ownedBy(User $user): bool
    {
        return (int) $this->user_id === (int) $user->id;
    }

    /**
     * Whether the given user is the linked contact (expense side).
     */
    public function belongsToUser(User $user): bool
    {
        return $this->ownOrLinkedBy($user);
    }

    /**
     * Whether this permuta involves the user in any side.
     */
    public function ownOrLinkedBy(User $user): bool
    {
        return $this->ownedBy($user)
            || ((int) $this->contato_id === (int) $user->id);
    }
}
