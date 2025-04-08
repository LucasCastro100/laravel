<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageUser extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_user')
            ->withPivot('deleted_at')
            ->withTimestamps();
    }

    // Método para excluir a mensagem para o usuário
    public function deleteMessage($messageId)
    {
        $this->messages()->updateExistingPivot($messageId, ['deleted_at' => now()]);
    }
}
