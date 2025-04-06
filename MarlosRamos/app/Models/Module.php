<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Module extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'course_id'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
