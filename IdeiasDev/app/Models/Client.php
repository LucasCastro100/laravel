<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'document',
        'address',
        'notes',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'client_plan')
            ->using(ClientPlan::class)
            ->withPivot(['start_date', 'end_date', 'active', 'adjusted_value', 'user_id'])
            ->withTimestamps();
    }

    public function activePlans()
    {
        return $this->belongsToMany(Plan::class, 'client_plan')
            ->using(ClientPlan::class)
            ->withPivot(['start_date', 'end_date', 'active', 'adjusted_value', 'user_id'])
            ->withTimestamps()
            ->wherePivot('active', true);
    }

    public function accounts()
    {
        return $this->hasMany(ClientAccount::class);
    }
}
