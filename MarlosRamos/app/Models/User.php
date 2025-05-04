<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'phone',
        'image',
        'role'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function matriculationsCourses()
    {
        return $this->hasMany(MatriculationCourse::class);
    }

    public function matriculationsTests()
    {
        return $this->hasMany(MatriculationTest::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class)
            ->withPivot('completed_at')
            ->withTimestamps();
    }
}
