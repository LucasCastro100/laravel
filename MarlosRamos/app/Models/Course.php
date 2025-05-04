<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Course extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function matriculationsCourses()
    {
        return $this->hasMany(MatriculationCourse::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, MatriculationCourse::class, 'course_id', 'id', 'id', 'user_id');
    }
}
