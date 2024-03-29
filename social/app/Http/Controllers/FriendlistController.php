<?php

namespace App\Http\Controllers;

use App\Models\Friendlist;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendlistController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth' , 'verified']);   //  middleware per limitare l'accesso se non si è loggati o se non si ha fatto la verifica
    } 


       ////////////////     CREARE UNA RICHIESTA D' AMICIZIA O RIFIUTARLA SUL NASCERE   ///////////////////////

    public function store(Request $request)
    {
        $id = $request->input('id');
        $friendship = Friendship::find($id);
        $choise = $request->input('choise');

        if($choise == 'accepted'){
            $friendlist = new Friendlist();
            $friendlist->request_id = $id;
            $friendlist->user_id = $friendship->user_id;
            $friendlist->friend_id = $friendship->friend_id;
            $friendship->status = 'accettata';

            $friendship->update();
            $friendlist->save();

            return redirect()->route('friendships.index');

        }else{
           $friendship->delete();
           return redirect()->route('friendships.index');
        }
        
    }


     
   ////////////////     MOSTRARE LISTA AMICI DI UN UTENTE  ///////////////////////

   public function show($user_id){
    $friendlists = Friendlist::where('user_id',$user_id)->orWhere('friend_id',$user_id)->get();   
    $user = User::find($user_id);

     return view('friendlist.friend_list', [
        'friendlists' => $friendlists,
        'user' => $user,
    ]);  
}


    ////////////////    CANCELLARE UN' AMICIZIA  //////////////////////
   
    public function delete($id)
    {
        $friendlist = Friendlist::find($id);
        $friendship = Friendship::where('user_id',$friendlist->user_id)->where('friend_id',$friendlist->friend_id)
                                ->orWhere('user_id',$friendlist->friend_id)->where('friend_id',$friendlist->user_id)
                                ->first();

        if($friendship->user_id == Auth::user()->id){
            $user_id = $friendship->friend_id;

        }else if($friendship->friend_id == Auth::user()->id){
            $user_id = $friendship->user_id;
        }

        $friendlist->delete();
        $friendship->delete();
       
       if(isset($_GET['profile'])){

           return redirect()->route('users.show', ['user' => $user_id]);

       }else{
        $user = User::find(Auth::user()->id);
        $friendlists = Friendlist::where('user_id',$user->id)->orWhere('friend_id',$user->id)->get(); 
    
        return view('friendlist.friend_list', [
           'friendlists' => $friendlists,
           'user' => $user, ]);
       }
        
    }

   

}
