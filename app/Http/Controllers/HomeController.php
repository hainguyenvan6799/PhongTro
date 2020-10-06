<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use App\Events\newMessage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('user_id', '!=', Auth::user()->user_id)->get();
        $login_user = User::where('user_id', Auth::user()->user_id)->get();
        return view('home', compact(['users', 'login_user']));
    }

    public function postMessage(Request $request){
        $from = Auth::user()->user_id;
        $to = (int)$request->received_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->content = $message;
        $data->is_read = 0;
        $data->save();

        event(new newMessage($data)); // onject
    }
}
