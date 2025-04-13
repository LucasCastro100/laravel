<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $uuid_classroom)
    {
        // Validação do comentário
        $request->validate([
            'comment' => 'required|string|max:1000', // Valida o comentário
        ]);

        // Encontrar a aula com base no UUID
        $classroom = Classroom::where('uuid', $uuid_classroom)->firstOrFail();

        // Criar um novo comentário
        Comment::create([
            'content' => $request->comment,
            'classroom_id' => $classroom->id,
            'user_id' => Auth::id(), // Associar o comentário ao usuário logado
        ]);

        return redirect()->route('classroom.show', ['uuid_classroom' => $uuid_classroom])
                         ->with('success', 'Comentário enviado com sucesso!');
    }
}
