<?php

namespace App\Livewire;

use App\Models\Friendship;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FriendsList extends Component
{
    public $friends = [];

    public function mount()
    {
        $this->loadFriends();
    }

    public function loadFriends()
    {        
        $this->friends = Friendship::where(function($query) {
            $query->where('user_id', Auth::id())
                  ->orWhere('friend_id', Auth::id());
        })
        ->where('status', '!=', 'rejected')
        ->with(['user', 'friend'])->get();                
    }    

    public function render()
    {
        return view('livewire.friends-list', ['friends' => $this->friends]);
    }
}
