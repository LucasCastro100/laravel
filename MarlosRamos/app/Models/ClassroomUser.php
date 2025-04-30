<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomUser extends Model
{
    use HasFactory;

    // Defina a tabela associada ao modelo
    protected $table = 'classroom_user';

    // Defina os campos preenchíveis
    protected $fillable = [
        'user_id',
        'classroom_id',
        'completed_at',
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com a aula
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Acessor para verificar se a aula foi concluída
    public function getIsCompletedAttribute()
    {
        return !is_null($this->completed_at);
    }
}
