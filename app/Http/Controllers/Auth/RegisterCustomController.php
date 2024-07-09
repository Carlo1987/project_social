<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Friendship;
use App\Models\Theme;

class RegisterCustomController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }



    public function register(Request $request){

        $text_validate = json_decode($request->input('text_validate'),true);

        $message_empty_field = $text_validate['field_required'];
        $message_maxLetters = $text_validate['maxLetters'];

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'surname' => ['required', 'string', 'max:150'],
            'gender' => ['required', 'string', 'max:10'],
            'nick' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'max:15', 'confirmed'],
            'type' => ['required', 'string', 'max:20'],
     ],
    [
        'name.required' => $message_empty_field,
        'name.max' =>  $message_maxLetters.' 100',
        'surname.required' => $message_empty_field,
        'surname.max' => $message_maxLetters.' 150',
        'gender.required' => $message_empty_field,
        'nick.required' => $message_empty_field,
        'nick.max' => $message_maxLetters.' 100',
        'email.required' => $message_empty_field,
        'email.max' => $message_maxLetters.' 200',
        'email.email' => $text_validate['email_invalid'],
        'email.unique' => $text_validate['email_doble'],
        'password.required' => $message_empty_field,
        'password.min' => $text_validate['password_min'],
        'password.max' => $message_maxLetters.' 15',
        'password.confirmed' => $text_validate['password_confirm'],
        'type.required' => $message_empty_field           
       ]);


       if(request()->hasfile('img')){
            $imageName = time().request()->img->getClientOriginalName();
        Storage::disk('users')->put($imageName, File::get(request()->file('img')));
       }else{
            $imageName = 'user_default.png';
       }

       $user = new User;

       $user->name = $request->input('name');
       $user->surname = $request->input('surname');
       $user->gender = $request->input('gender');
       $user->nick = $request->input('nick');
       $user->email = $request->input('email');
       $user->password =  Hash::make($request->input('password'));
       $user->img = $imageName ;
       $user->type = $request->input('type');

       $user->save();


       $last_user = User::orderBy('id','desc')->limit(1)->first();      /*  utente appena registrato */

       $theme = new Theme();                    /*   creo tabella Theme per la scelta dei temi per l'utente appena registrato   */
       $theme->user_id = $last_user->id;
       $theme->theme = 'default';
       $theme->save();

       $developer = User::where('id',1)->first();
       $friendship = new Friendship();            /*  richiesta di amicizia di default da parte dello sviluppatore  :-)    */
       $friendship->user_id = $developer->id;
       $friendship->friend_id = $last_user->id;
       $friendship->status = 'in sospeso';
       $friendship->save();

       Auth::login($last_user);

       $cookie = new CookieController();
       $cookie_session = $cookie->setCookie(Auth::id());

       return redirect()->route('welcome')->withCookie($cookie_session);
 
    }


}
