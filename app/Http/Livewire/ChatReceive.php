<?php

namespace App\Http\Livewire;

use App\messageChat;
use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatReceive extends Component
{
    public $user, $userName, $userNames, $room_dev, $chat_receive, $receiver_id;

    protected $listeners = ['refreshChat' => 'render'];

    public function render()
    {
        $this->room_dev = messageChat::orderBy('id', 'asc')->get();
        return view('livewire.chat-receive');
    }

    public function mount($id)
    {
        $this->receiver_id = $id;
    }
}
