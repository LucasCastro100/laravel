<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'friend_id',
        'status'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
