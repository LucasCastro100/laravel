<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\Chat as ModelsChat;
use Livewire\Component;

class Chat extends Component
{
    public $messages = [];
    public $newMessage;
    public $friendId;
    public $lastMessageId;

    public function mount($friendId)
    {
        $this->friendId = $friendId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (Auth::user()->role_value == 3) {
            $messages = ModelsChat::orderBy('created_at', 'asc')->get();
        } else {
            $messages = ModelsChat::where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->friendId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->friendId)
                    ->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();
        }

        $groupedMessages = [];
        foreach ($messages as $message) {
            $date = $message->created_at->format('d/m/Y');
            if (!isset($groupedMessages[$date])) {
                $groupedMessages[$date] = [];
            }
            $groupedMessages[$date][] = $message;
        }

        $this->messages = $groupedMessages;
        $this->lastMessageId = $messages->last()->id ?? null;
    }

    public function checkForNewMessages()
    {
        $latestMessage = ModelsChat::orderBy('created_at', 'asc')->first();
        if ($latestMessage && $latestMessage->id != $this->lastMessageId) {
            $this->loadMessages();            
        }
    }

    public function sendMessage()
    {
        ModelsChat::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $this->friendId,
            'chat' => $this->newMessage,
        ]);

        $this->newMessage = '';
        $this->loadMessages();
        $this->dispatch('messagesUpdated');        
    }

    public function updatedMessages()
    {
        $this->dispatch('messagesUpdated');
    }

    public function render()
    {
        return view('livewire.chat');
    }
}