<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\CookieController;
use App\Models\User;
use App\Models\Theme;
use App\Models\Image;
use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Friendship;
use App\Models\Friendlist;
use App\Models\Chat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   //   aggiunto per usare Auth (utente identificato)
use Illuminate\Support\Facades\Hash;   //  aggiunto per usare hash per password
use Illuminate\Support\Facades\Storage; // aggiunto per usare Storage per le immagini
use Illuminate\Support\Facades\File; // aggiunto per usare file per le immagini
use Illuminate\Http\Response;  //  aggiunto per prendere img da storage
use Illuminate\Support\Facades\DB;    // aggiunto per fare delle consulte dirette con il database

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);  

    }

    /////////////   VISUALIZZARE INDEX CON TUTTI GLI UTENTI VISIBILI PER L'UTENTE  ////////////////

    public function index()
    {
        $images = Image::orderBy('id', 'desc')->get();
        $videos = Video::orderBy('id', 'desc')->get();
       
         return view('index', [
            'images' => $images,
            'videos' => $videos,
            'user' => Auth::user()
        ]);   
    }


    /////////////   CERCARE ALTRI UTENTI  ////////////////

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'string'
        ]);

        $search = $request->input('search');

        $users = User::where('name', 'like', $search.'%')->where('id','!=',Auth::user()->id)
            ->orWhere('surname', 'like', $search.'%')->where('id','!=',Auth::user()->id)
            ->orWhere('nick', 'like', $search.'%')->where('id','!=',Auth::user()->id)
            ->get();

            return view('user.search', [
                'users' => $users
            ]);
    }


    /////////////   MOSTRARE PROFILO DI UN UTENTE  ////////////////

    public function show(User $user)
    {
        $images = Image::where('user_id', '=', $user->id)->orderBy('id', 'desc')->get();
        $videos = Video::where('user_id', '=', $user->id)->orderBy('id', 'desc')->get();
        $image_maxID = Image::where('user_id', $user->id)->orderBy('id','desc')->limit(1)->first();
        $video_maxID = Video::where('user_id', $user->id)->orderBy('id','desc')->limit(1)->first();
        $friendships = Friendship::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();         //  richieste fatte dall'utente (in sospeso e accettate)
        $friend_requests = Friendship::where('friend_id', Auth::user()->id)->orderBy('id', 'desc')->get();      //  richieste ricevute da altri utenti (in sospeso e accettate)
        $friendlists = Friendlist::where('user_id', $user->id)->orWhere('friend_id', $user->id)->get();   //  lista amici
        $chat_noView = Chat::where('user2',Auth::user()->id)->where('view',false)->count(); 

        if($user->id != Auth::id()){
            $chat_noView = Chat::where('user2',Auth::id())->where('user1',$user->id)->where('view',false)->count(); 
        }

        $chat = array(
            "friend_id" => $user->id,
            'friend_name' => $user->name,
            'friend_surname' => $user->surname,
            'friend_nick' => $user->nick,
            'friend_image' => $user->img,
            'auth_id' => Auth::id(),
            'auth_nick' => Auth::user()->nick,
            'auth_image' => Auth::user()->img,
            'count' => $chat_noView
        );

         return view('user.profile', [
            'images' => $images,
            'videos' => $videos,
            'image_maxID' => $image_maxID,
            'video_maxID' => $video_maxID,
            'friendships' => $friendships,
            'friend_requests' => $friend_requests,
            'friendlists' => $friendlists,
            'chat' => $chat,
            'user' => $user
        ]); 
    }




    ////////////   MOSTRARE PROFILO DI UN UTENTE  ////////////////


    public function show_chats(){
        $chats_all = DB::select('select * from chats where user1='.Auth::id().' or user2='.Auth::id());
        $user = User::where('id',Auth::id())->first();

        $chats = array();

          function data($id,$user,$count){
            return array(
                "friend_id" => $id,
                'friend_name' => $user->name,
                'friend_surname' => $user->surname,
                'friend_nick' => $user->nick,
                'friend_image' => $user->img,
                'auth_id' => Auth::id(),
                'auth_nick' => Auth::user()->nick,
                'auth_image' => Auth::user()->img,
                'count' => $count
                );
           }    

        foreach($chats_all as $elem){
            if($elem->user1 == Auth::id()){
                $result = array_key_exists($elem->user2,$chats); 
                if(!$result){
                    $user = User::where('id',$elem->user2)->first();
                    $chats[$elem->user2] = data($elem->user2,$user,0);
                }
            
            }else if($elem->user2 == Auth::id()){
                $result = array_key_exists($elem->user1,$chats); 
                $view = $elem->view;

                  if(!$result){
                    $user = User::where('id',$elem->user1)->first();
                    if(!$view){
                        $chats[$elem->user1] = data($elem->user1,$user,1);
                    }else{
                        $chats[$elem->user1] = data($elem->user1,$user,0);
                    }
                
                  }else if($result && !$view){
                    $chats[$elem->user1]['count'] ++;
                  }            
            } 
        }
   

         return view('chat.list', [
            'chats' => $chats,
            'user' => $user
        ]);   
    }



    /////////////   MODIFICARE DATI UTENTE  ////////////////

    public function editDatos()
    {
        return view('user.edit');
    }


    public function update(Request $request, User $user)
    {
        $text_validate = json_decode($request->input('text_validate'),true);

        $request->validate([
            'name' => 'string|max:100',
            'surname' => 'string|max:150',
            'nick' => 'string|max:100',
            'email' => 'max:200|email|required',
        ],
        [
            'nick.string' => $text_validate['no_number'],
            'name.string' => $text_validate['no_number'],
            'surname.string' => $text_validate['no_number'],
            'email.required' => $text_validate['field_required'],
            'email.email' => $text_validate['email_invalid'],
        ]);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->gender = $request->input('gender');
        $user->nick = $request->input('nick');
        $user->email = $request->input('email');
        $user->type = $request->input('type');

        $user->save();

        return redirect()->back()->with(['message' => $text_validate['datas_success']]);
    }


    public function editPassword()
    {
        return view('user.editPassword');
    }


    public function updatePassword(Request $request)
    {
        $text_validate = json_decode($request->input('text_validate'),true);

        $user = Auth::user();
        $user_Password = $user->password;

        $request->validate([
            'old_Password' => 'min:4|max:255',
            'password' => 'min:4|max:255',
            'password_confirmation' => 'min:4|max:255',
        ],
        [
            'old_Password.min' => $text_validate['password_min'],
            'password.min' => $text_validate['password_min'],
            'password_confirmation.min' => $text_validate['password_min'],
        ]);

        $old_Password = $request->input('old_Password');
        $new_Password = $request->input('password');
        $confir_Password = $request->input('password_confirmation');

        if ($old_Password && Hash::check($old_Password, $user_Password)) {
            if ($new_Password && $confir_Password && $new_Password == $confir_Password) {

                $new_Password = Hash::make($new_Password);
                $user->password = $new_Password;

                $user->save();
            } else {
               return redirect()->back()->with(['error_password' => $text_validate['password_confirm']]);
            }
        } else {
            return redirect()->back()->with(['error_password' => $text_validate['old_password_wrong']]);
          
        }


        return redirect()->back()->with(['message' => $text_validate['password_success']]);
    }


    /////////////////   SALVARE  IMMAGINE AVATAR DELL' UTENTE   ////////////////////

    public function avatar()
    {
        return view('user.avatar');
    }


    public function updateAvatar(Request $request)
    {

        $text_validate = json_decode($request->input('text_validate'),true);

        $user = Auth::user();

        $request->validate([
            'avatar' => ['mimes:jpeg,jpg,png,gif,webp', 'required'],
        ],
        [
            "avatar.required" => $text_validate['no_file'],
            "avatar.mimes" =>  $text_validate['invalid_format'],
        ]);

        $image = $request->file('avatar');
        $image_name = time() . $image->getClientOriginalName();

        if($user->img != 'user_default.png'){
            Storage::disk('users')->delete($user->img);
        }

        Storage::disk('users')->put($image_name, File::get($image));

        $user->img = $image_name;
        $user->save();

        return redirect()->back()->with(['message' => $text_validate['avatar_success']]);
    }


    /////////////////   VISUALIZZARE IMMAGINE AVATAR DELL' UTENTE CON response   ////////////////////

    public function getAvatar($avatar)
    { 
        $file = Storage::disk('users')->get($avatar);
        $type = Storage::mimeType($file); 

        $response = new Response($file, 200);
        return $response->header('Content-Type', $type); 
    }



    /////////////////   CAMBIARE TEMA ACOUNT  ////////////////////

    public function theme(){
        return view('user.theme');
    }

    public function change_theme(Request $request){
        $theme = Theme::where('user_id',Auth::user()->id)->first();
        $theme->user_id = Auth::user()->id;
        $theme->theme = $request->input('theme');
    
        $theme->update();
        return redirect()->back();
    }


    /////////////////   CANCELLARE ACOUNT UTENTE   ////////////////////

    public function delete($id)
    {
        $user = User::find($id);

        return view('user.delete', [
            'user' => $user,
        ]);
    }


    public function deleteAcount($id, Request $request)
    {
        $auth_id = Auth::user()->id;
        if ($id == $auth_id) {
            if (isset($_POST['accept'])) {

                $user = User::find($id);
                $images = Image::where('user_id', $id)->get();
                $videos = Video::where('user_id', $id)->get();
                $likes = Like::where('user_id', $id)->get();
                $comments = Comment::where('user_id', $id)->get();
                $friendships = Friendship::where('user_id', $id)->orWhere('friend_id', $id)->get();
                $friendlists = Friendlist::where('user_id', $id)->orWhere('friend_id', $id)->get();
                $chats = Chat::where('user1',$auth_id)->orWhere('user2',$auth_id)->get();

                if ($chats->count() != 0){
                    foreach ($chats as $chat){
                        $chat->delete();
                    }
                }

                if ($friendlists->count() != 0) {
                    foreach ($friendlists as $friendlist) {    //   elimina tutte le amicizie
                        $friendlist->delete();
                    }
                }

                if ($friendships->count() != 0) {
                    foreach ($friendships as $friendship) {    //  elimina tutte le rihieste di amicizia
                        $friendship->delete();
                    }
                }

                if ($comments->count() != 0) {
                    foreach ($comments as $comment) {    //  elimina tutti i commenti fatti dall'utente loggato
                        $comment->delete();
                    }
                }

                if ($images->count() != 0) {
                    foreach ($images as $image) {
                        foreach ($image->comments as $comment) {    //   elimina tutti i commenti fatti dagli altri utenti sulle immagini dell'utente loggato
                            $comment->delete();
                        }
                    }
                }

                if ($videos->count() != 0) {
                    foreach ($videos as $video) {
                        foreach ($video->comments as $comment) {    //   elimina tutti i commenti fatti dagli altri utenti sui video dell'utente loggato
                            $comment->delete();
                        }
                    }
                }

                if ($likes->count() != 0) {
                    foreach ($likes as $like) {   //  elimina tutti i like messi dall'utente loggato
                        $like->delete();
                    }
                }


                if ($images->count() != 0) {
                    foreach ($images as $image) {
                        foreach ($image->likes as $like) {    //   elimina tutti i like fatti dagli altri utenti sulle immagini dell'utente loggato
                            $like->delete();
                        }
                    }
                }

                if ($videos->count() != 0) {
                    foreach ($videos as $video) {
                        foreach ($video->likes as $like) {    //   elimina tutti i like fatti dagli altri utenti sui video dell'utente loggato
                            $like->delete();
                        }
                    }
                }

                if ($images->count() != 0) {
                    foreach ($images as $image) {    //  elimina tutte le immagini dell'utente loggato
                        $image->delete();
                    }
                }

                if ($videos->count() != 0) {
                    foreach ($videos as $video) {    //  elimina tutti i video dell'utente loggato
                        $video->delete();
                    }
                }

                if($user->img != 'user_default.png'){
                    Storage::disk('users')->delete($user->img);   //  elimina immagine avatar dalla memoria
                }

                DB::table('themes')->where('user_id',$id)->delete();
                
               
                $user->delete();    //  elimina l'utente

                $cookie = new CookieController();
                $cookie_deleted = $cookie->deleteCookie();

                return redirect('/')->cookie($cookie_deleted);
                
            }
        } 
    }
}
