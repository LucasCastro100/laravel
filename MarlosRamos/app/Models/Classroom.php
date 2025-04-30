<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Classroom extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'video',
        'duration',
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot('completed_at');
    }    
}
