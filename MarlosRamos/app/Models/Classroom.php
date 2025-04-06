<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Classroom extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'video',
        'module_id'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
