<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'answers',
        'scores',
        'percentual',
        'primary',
        'secondary',
        'uuid'
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

    public function matriculationsTests()
    {
        return $this->hasMany(MatriculationTest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
