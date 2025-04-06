<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'comment',
        'classroom_id',
        'user_id'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function classrooms()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
