<?php

namespace App\Models;

use App\Enums\SituationMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Definir os campos que podem ser atribuídos em massa
    protected $fillable = [
        'title',
        'description',
        'permission_level',
        'situation'
    ];

    // Realizando o cast para que o campo permission_level seja tratado como array
    protected $casts = [
        'permission_level' => 'array',  // Permite trabalhar com permission_level como um array
        'situation' => SituationMessage::class
    ];

    // Definindo o relacionamento com o modelo User
    public function users()
    {
        return $this->belongsToMany(User::class, 'message_user')
            ->withPivot('deleted_at')  // Coluna para marcar quando o usuário excluiu a mensagem
            ->withTimestamps();
    }

    public function deleteMessageForUser($userId)
    {
        // Exclui a mensagem para o usuário com o soft delete
        $this->users()->updateExistingPivot($userId, ['deleted_at' => now()]);
    }
}
