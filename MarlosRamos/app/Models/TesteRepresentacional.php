<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesteRepresentacional extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'phone',
        'answers',
        'scores',
        'percentual',
        'primary',
        'secondary',
    ];

    protected $casts = [
        'answers' => 'array',
        'scores' => 'array',
        'percentual' => 'array',
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }
}
