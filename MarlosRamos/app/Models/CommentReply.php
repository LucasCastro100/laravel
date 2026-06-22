<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CommentReply extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'comment_id',
        'user_id',
        'reply',
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function comment() {
        return $this->belongsTo(Comment::class);
    }
}
