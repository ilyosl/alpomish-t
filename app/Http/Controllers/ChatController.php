<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Http\Requests\MessageFormRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __constructor(){
        $this->user = Auth::user();
    }

    public function index(){
        $user = Auth::user();
        return view('chat');
    }

    public function messages(){
        return Message::query()->with('user')
            ->get();
    }

    public function send(MessageFormRequest $request){
        $message = $request->user()
            ->messages()
            ->create($request->validated());
        $client = new \WebSocket\Client("ws://10.69.69.24:8080");
        $client->text($message);
        $client->receive();
        $client->close();
//        event(new MessageSend($request->user(), $message));
        return $message;
    }
}
