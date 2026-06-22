<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:1000',
        ], [
            'reply.required' => 'O campo resposta é obrigatório.',
            'reply.string'   => 'O campo resposta deve ser um texto válido.',
            'reply.max'      => 'O campo resposta não pode ter mais de 1000 caracteres.',
        ]);

        try {
            $comment->replies()->create([
                'user_id' => Auth::user()->id,
                'reply'   => $validated['reply'],
            ]);

            return back()->with('success', 'Resposta enviada com sucesso!');
        } catch (\Exception $e) {

            return back()->with('error', 'Ocorreu um erro ao salvar a resposta. Tente novamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $commentReply)
    {
        $commentReply = Comment::with(['user', 'replies.user',  'classroom.module.course'])->where('uuid', $commentReply)->first();
        
        $dados = [
            'title' => 'Respondendo Comentário',
            'commentReply' => $commentReply
        ];

        // dd($commentReply);

        return view('dashboard.teacher.comment.reply', $dados);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommentReply $commentReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommentReply $commentReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommentReply $commentReply)
    {
        //
    }
}
