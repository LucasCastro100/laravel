<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Client;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Chat - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => 'chatList',
        ];

        return view('pages.auth.dashboard.list.friends-list', $dados);
    }

    public function show(Request $request, int $friendId)
    {
        $client = Client::where('user_id', $friendId)->first();
        $dados = [
            'titlePage' => 'Chat - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => 'chatService',
            'friendId' => $friendId,
            'client' => $client->name,
        ];

        $friendship = Friendship::where(function ($query) use ($friendId) {
            $query->where(function ($query) use ($friendId) {
                $query->where('user_id', Auth::user()->id)
                    ->where('friend_id', $friendId);
            })->orWhere(function ($query) use ($friendId) {
                $query->where('user_id', $friendId)
                    ->where('friend_id', Auth::user()->id);
            });
        })->where('status', '!=', 'rejected')
            ->first();

        if ($friendship && $friendship->status === 'accepted') {
            return view('pages.auth.dashboard.show.chat', $dados);
        } else {
            return redirect()->route('dashboard.chat.index')->with('error', 'Você não tem permissão apra iniciar esa conversa!')->with('status', 'erro');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Chat $chat)
    {
        //
    }

    public function update(Request $request, Chat $chat)
    {
        //
    }

    public function destroy(Chat $chat)
    {
        //
    }
}
