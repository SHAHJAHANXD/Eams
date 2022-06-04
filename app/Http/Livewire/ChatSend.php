<?php

namespace App\Http\Livewire;

use App\messageChat;
use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatSend extends Component
{
    public $receiver_id, $message, $users;

    public function render()
    {
        return view('livewire.chat-send');
    }

    public function mount($id)
    {
        $this->receiver_id = $id;
        $this->users = messageChat::where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id())->get();
        $this->userNames = User::where('id', Auth::id())->get();
        $this->emit('mount');
    }

    public function ResetInputField()
    {
        $this->message = '';
    }

    public function store()
    {
        // dd($this->receiver_id, $this->message);
        // $request->validate([
        //     'message' => 'required|max:255',
        //     'folder' => 'mimes:jpeg,jpg,png,gif,pdf|max:3072',
        // ]);
        $id = Auth::user()->id;

        $room = new messageChat();
        if (Auth::user()->id == $id) {
            $room->receiver_id = $this->receiver_id;
            $room->sender_id = $id;
        }
        $room->message = $this->message;
        $room->save();
        $this->ResetInputField();
       $this->emit('refreshChat');
    }
}
