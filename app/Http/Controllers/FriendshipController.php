<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\Friendlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);  
    } 


    ///////////////  CREARE UNA NUOVA RICHIESTA DI AMICIZIA  ///////////

    public function store(Request $request)
    {
        $friendship = new Friendship();

        if($request->input('friend') == 1 || $request->input('friend') > 19){     ////   richiesta ad utenti reali
            $friendship->user_id = $request->input('user');
            $friendship->friend_id = $request->input('friend');
            $friendship->status = 'in sospeso';
    
            $friendship->save();
    
            return redirect()->route('users.show', ['user' => $request->input('friend')]);

         }else{                                ////   richiesta ad utenti fittizzi
            $friendship->user_id = $request->input('user');
            $friendship->friend_id = $request->input('friend');
            $friendship->status = 'accettata';
            $friendship->save();

            $last_friendship = Friendship::orderBy('id','desc')->limit(1)->first();
            $friendlist = new Friendlist();
      
            $friendlist->request_id = $last_friendship->id;
            $friendlist->user_id = $last_friendship->user_id;
             $friendlist->friend_id = $last_friendship->friend_id;
             $friendlist->save();
           
            return redirect()->route('users.show', ['user' => $request->input('friend')]);
        } 

    
    }


  ////////////////    MOSTRARE LISTA RICHIESTE DI AMICIZIA FATTE(friendships) E RICEVUTE(friend_request)

    public function index()
    {
        $friendships = Friendship::where('user_id' , Auth::user()->id)->where('status','in sospeso')->orderBy('id','desc')->get();
        $friend_requests = Friendship::where('friend_id' , Auth::user()->id)->where('status','in sospeso')->orderBy('id','desc')->get();
    
        return view('friendship.list', [
            'friendships' => $friendships,
            'friend_requests' => $friend_requests,
        ]);
    }

 



}
