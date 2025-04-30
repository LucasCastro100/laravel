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
        return $this->belongsToMany(Course::class, 'matriculations');
    }

    public function matriculations()
    {
        return $this->hasMany(Matriculation::class);
    }

    public function testes()
    {
        return $this->belongsToMany(Test::class, 'users_tests');
    }

    public function completedClassrooms()
    {
        return $this->belongsToMany(Classroom::class)
            ->withTimestamps()
            ->withPivot('completed_at');
    }
}
