<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Theme;
use App\Models\Image;
use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Friendship;
use App\Models\Friendlist;
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
        $this->middleware(['auth' , 'verified']);   //  middleware per limitare l'accesso se non si è loggati o se non si ha fatto la verifica
    }

    /////////////   VISUALIZZARE INDEX CON TUTTI GLI UTENTI VISIBILI PER L'UTENTE  ////////////////

    public function index()
    {
        $images = Image::orderBy('id', 'desc')->get();
        $videos = Video::orderBy('id', 'desc')->get();
      
        return view('index', [
            'images' => $images,
            'videos' => $videos,
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

        return view('user.profile', [
            'images' => $images,
            'videos' => $videos,
            'image_maxID' => $image_maxID,
            'video_maxID' => $video_maxID,
            'friendships' => $friendships,
            'friend_requests' => $friend_requests,
            'friendlists' => $friendlists,
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
        $request->validate([
            'name' => 'string|max:100',
            'surname' => 'string|max:150',
            'nick' => 'string|max:100',
            'email' => 'string|max:200|email',
        ]);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->gender = $request->input('gender');
        $user->nick = $request->input('nick');
        $user->email = $request->input('email');
        $user->type = $request->input('type');

        $user->save();

        return redirect()->back()->with(['message' => 'Dati modificati con successo']);
    }


    public function editPassword()
    {
        return view('user.editPassword');
    }


    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $user_Password = $user->password;

        $request->validate([
            'old_Password' => 'string|min:4|max:255',
            'password' => 'string|min:4|max:255',
            'password_confirmation' => 'string|min:4|max:255',
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
                return redirect()->back()->with(['error' => 'Hai messo due password diverse, riprovare']);
            }
        } else {
            return redirect()->back()->with(['error' => 'Vecchia password errata, riprovare']);
        }

        return redirect()->back()->with(['message' => 'Password aggiornata']);
    }


    /////////////////   SALVARE  IMMAGINE AVATAR DELL' UTENTE   ////////////////////

    public function avatar()
    {
        return view('user.avatar');
    }


    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'img' => 'image',
        ]);

        $image = $request->file('img');
        $image_name = time() . $image->getClientOriginalName();

        if($user->img != 'user_default.png'){
            Storage::disk('users')->delete($user->img);
        }

        Storage::disk('users')->put($image_name, File::get($image));

        $user->img = $image_name;
        $user->save();

        return redirect()->back()->with(['message' => 'Immagine Profilo aggiornata']);
    }


    /////////////////   VISUALIZZARE IMMAGINE AVATAR DELL' UTENTE CON response   ////////////////////

    public function getAvatar($avatar)
    { 
        $file = Storage::disk('users')->get($avatar);
        return new Response($file, 200); 
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


    public function deleteAcount($id)
    {
        if ($id == Auth::user()->id) {
            if (isset($_GET['accept'])) {

                $user = User::find($id);
                $images = Image::where('user_id', $id)->get();
                $videos = Video::where('user_id', $id)->get();
                $likes = Like::where('user_id', $id)->get();
                $comments = Comment::where('user_id', $id)->get();
                $friendships = Friendship::where('user_id', $id)->orWhere('friend_id', $id)->get();
                $friendlists = Friendlist::where('user_id', $id)->orWhere('friend_id', $id)->get();

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

                return redirect('/');
                
            } elseif (isset($_GET['rejection'])) {
                return redirect()->back();
            }
        }
    }
}
