<?php

namespace App\Http\Controllers;

use App\messageChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'message' => 'required|max:255',
        //     'folder' => 'mimes:jpeg,jpg,png,gif,pdf|max:3072',
        // ]);
        $id = Auth::user()->id;
        $room = new messageChat();
        if(Auth::user()->id == $id)
        {
          $room->receiver_id = $request->receiver_id;
          $room->sender_id = $id;
        }
        $room->message = $request->message;
        $room->save();
        return redirect()->back()->with('message','Room Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\messageChat  $messageChat
     * @return \Illuminate\Http\Response
     */
    public function show(messageChat $messageChat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\messageChat  $messageChat
     * @return \Illuminate\Http\Response
     */
    public function edit(messageChat $messageChat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\messageChat  $messageChat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, messageChat $messageChat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\messageChat  $messageChat
     * @return \Illuminate\Http\Response
     */
    public function destroy(messageChat $messageChat)
    {
        //
    }
}
