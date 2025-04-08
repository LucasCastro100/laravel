<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function convityFriend($friendId)
    {
        $user = Auth::user();
        
        $data = [
            'user_id' => $user->id,
            'friend_id' => $friendId            
        ];

        $query = Friendship::create($data);

        return redirect()->route('dashboard.chat.index')->with('message', 'Convite enviado.')->with('status', 'success');
    }

    public function acceptFriend($uuid)
    {
        $friendship = Friendship::where('uuid', $uuid)->first();
        $friendship->status = 'accepted';
        $friendship->save();

        return redirect()->back()->with('message', 'Convite aceito.')->with('status', 'success');
    }

    public function rejectFriend($uuid)
    {
        $friendship = Friendship::where('uuid', $uuid)->first();
        $friendship->status = 'rejected';
        $friendship->save();

        return redirect()->back()->with('message', 'Convite rejeitado.')->with('status', 'erro');
    }

    public function saleBooth($friendId)
    {
        $user = Auth::user();
        
        $data = [
            'user_id' => $user->id,
            'friend_id' => $friendId,
            'status' => 'accepted'
        ];

        $query = Friendship::create($data);

        return redirect()->route('dashboard.chat.index')->with('message', 'Convite enviado.')->with('status', 'success');
    }
}
