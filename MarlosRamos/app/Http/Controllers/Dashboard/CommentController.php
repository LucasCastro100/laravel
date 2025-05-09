<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(){

    }

    public function classroomShow(){

    }

    public function store(Request $request, $uuid_classroom)
    {
        try {
            // Validação do comentário
            $request->validate([
                'comment' => 'required|string|max:1000', // Valida o comentário
            ]);

            // Encontrar a aula com base no UUID
            $classroom = Classroom::where('uuid', $uuid_classroom)->firstOrFail();

            // Criar um novo comentário
            Comment::create([
                'comment' => $request->comment,
                'classroom_id' => $classroom->id,
                'user_id' => Auth::id(), // Associar o comentário ao usuário logado
            ]);

            return redirect()->route('classroom.show', ['uuid_classroom' => $uuid_classroom])
                ->with('success', 'Comentário enviado com sucesso!');
        } catch (\Exception $e) {
            // Se ocorrer um erro, redireciona de volta com uma mensagem de erro
            return redirect()->back()
                ->with('error', 'Erro ao enviar o comentário!');
        }
    }
}
