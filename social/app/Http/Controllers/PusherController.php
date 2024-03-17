<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use Illuminate\Http\Request;

class PusherController extends Controller
{
    
    public function index(){
        return view('chat.index');
    }


    public function broadcast(Request $request){       //  
      //  $request->validate(['message' => 'string']);
       /*  $message = $request->input('message');
        return response()->json([
            'message' => $message
        ]); */
         broadcast(new PusherBroadcast($request->get('message')))->toOthers();
        return view('chat.broadcast', ['message' => $request->get('message')]); 
       // return view('chat.index' , ['message' => $request->input('message')]);
    }


    public function receive(Request $request){
        return view('chat.receive', ['message' => $request->get('message')]);
    }
}
