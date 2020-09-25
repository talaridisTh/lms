<?php

namespace App\Http\Controllers;

use App\Message;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    public function index()
    {
        $instructors = Role::find(2)->users;


        return view("index.chat.message",compact("instructors"));
    }

    public function receiver($user)
    {

        $instructors = Role::find(2)->users;



        $currentUser = Auth::user()->id;

        $message = Message::where(function ($q) use ($currentUser,$user){
            $q->where("from",$currentUser)->where("to",$user);
        })->orWhere(function ($q) use ($currentUser,$user){
            $q->where("from",$user)->where("to",$currentUser);
        })->get();




        return view("index.chat.chat",compact("message"));


    }

    public function sendMessage(Request $request)
    {

        $message = new Message;
        $message->from = Auth::id();
        $message->to = $request->receiver;
        $message->message =$request->message;
        $message->read = 0;
        $message->save();


    }
}
