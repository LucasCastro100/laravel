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
        'price',
        'certificate',
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
        return $this->belongsToMany(
            User::class,
            'matriculation_courses',
            'course_id', 
            'user_id'    
        )->withTimestamps()->withPivot('uuid');
    }
}
