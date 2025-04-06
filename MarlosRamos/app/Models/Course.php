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
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'matriculations');
    }
}
