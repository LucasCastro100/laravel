<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Student extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'registration'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
