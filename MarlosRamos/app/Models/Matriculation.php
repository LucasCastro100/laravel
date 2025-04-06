<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Matriculation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'curse_id',
        'user_id'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function curses()
    {
        return $this->belongsTo(Course::class);
    }
}
