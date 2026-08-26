<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\StateFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A Brazilian federative unit (estado/UF) imported from IBGE.
 *
 * @property int $id
 * @property string $name
 * @property string $uf
 * @property string $region
 * @property int $ibge_code
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read Collection<int, Municipality> $municipalities
 */
#[Fillable(['name', 'uf', 'region', 'ibge_code'])]
class State extends Model
{
    /** @use HasFactory<StateFactory> */
    use HasFactory;

    /**
     * Get the municipalities that belong to the state.
     *
     * @return HasMany<Municipality, $this>
     */
    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }
}
