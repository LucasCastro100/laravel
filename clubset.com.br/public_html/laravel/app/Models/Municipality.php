<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\MunicipalityFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A Brazilian municipality (município) imported from IBGE.
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property int $ibge_code
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read State $state
 */
#[Fillable(['name', 'state_id', 'ibge_code'])]
class Municipality extends Model
{
    /** @use HasFactory<MunicipalityFactory> */
    use HasFactory;

    /**
     * Get the state the municipality belongs to.
     *
     * @return BelongsTo<State, $this>
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
