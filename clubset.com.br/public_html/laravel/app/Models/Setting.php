<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Key-value platform settings managed by the administrator.
 *
 * @property int $id
 * @property string $group
 * @property string $key
 * @property string|null $value
 */
class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    /**
     * Retrieve a setting value by key.
     */
    public static function get(string $key, ?string $default = null, ?string $group = null): ?string
    {
        $query = static::query()->where('key', $key);
        if ($group !== null) {
            $query->where('group', $group);
        }
        $setting = $query->first();

        return $setting?->value ?? $default;
    }

    /**
     * Set or update a setting value.
     */
    public static function set(string $key, ?string $value, string $group = 'general'): static
    {
        return static::updateOrCreate(
            ['key' => $key, 'group' => $group],
            ['value' => $value],
        );
    }

    /**
     * Get all settings for a given group.
     *
     * @return array<string, string|null>
     */
    public static function group(string $group): array
    {
        return static::query()
            ->where('group', $group)
            ->pluck('value', 'key')
            ->all();
    }

    /**
     * Scope the query to a given group.
     *
     * @param  Builder<self>  $query
     */
    public function scopeOfGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }
}
