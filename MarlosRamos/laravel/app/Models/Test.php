<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function matriculationsTests()
    {
        return $this->hasMany(MatriculationTest::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, MatriculationTest::class, 'test_id', 'id', 'id', 'user_id');
    }
}
