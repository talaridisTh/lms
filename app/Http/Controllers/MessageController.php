<?php

namespace App\Http\Controllers;

use App\Message;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class MessageController extends Controller {

    //
    public function index()
    {


        $user = auth()->user();
        if ($user->getRoleNames()[0] == "student")
        {
            $users = DB::select("select users.id,users.email, count(is_read) as unread
        from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
        LEFT  JOIN  model_has_roles ON users.id = model_has_roles.model_id
        where model_has_roles.role_id = 2 or  model_has_roles.role_id = 1 and users.id != " . Auth::id() . "
        group by users.id, users.email");

        } else
        {


            $users = DB::select("select users.id,users.email, count(is_read) as unread
        from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
        where users.id != " . Auth::id() . "
        group by users.id, users.email");
        }


        return view("index.chat.message", compact("users"));
    }

    public function receiver($user)
    {

        Message::where(['from' => $user, 'to' => Auth::id()])->update(['is_read' => 1]);
        $currentUser = Auth::user()->id;
        $message = Message::where(function ($q) use ($currentUser, $user) {
            $q->where("from", $currentUser)->where("to", $user);
        })->orWhere(function ($q) use ($currentUser, $user) {
            $q->where("from", $user)->where("to", $currentUser);
        })->get();

        return view("index.chat.chat", compact("message"));
    }
    public function info( $user)
    {

        $user = User::findOrFail($user);




        return view("index.chat.chat-info", compact("user"));
    }

    public function sendMessage(Request $request)
    {

        $message = new Message;
        $message->from = Auth::id();
        $message->to = $request->receiver;
        $message->message = $request->message;
        $message->is_read = 0;
        $message->save();
        $options = [
            'cluster' => 'mt1',
            'useTLS' => true
        ];
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $dataMessage = ['from' => Auth::id(), 'to' => $request->receiver, "message" => $request->message, "updated_at" => now()->diffForHumans()];
        $pusher->trigger('my-channel', 'my-event', $dataMessage);
    }

}
