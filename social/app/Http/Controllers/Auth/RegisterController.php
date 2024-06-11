<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Theme;
use App\Models\Friendship;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // aggiunto per usare Storage per le immagini
use Illuminate\Support\Facades\File; // aggiunto per usare file per le immagini

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $text_validate = json_decode($data['text_validate']);

        $message_empty_field = $text_validate->field_required;
        $message_maxLetters = $text_validate->maxLetters;

        return Validator::make($data, [
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
            'email.email' => $text_validate->email_invalid,
            'email.unique' => $text_validate->email_doble,
            'password.required' => $message_empty_field,
            'password.min' => $text_validate->password_min,
            'password.max' => $message_maxLetters.' 15',
            'password.confirmed' => $text_validate->password_confirm,
            'type.required' => $message_empty_field            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(request()->hasfile('img')){
            $imageName = time().request()->img->getClientOriginalName();
            Storage::disk('users')->put($imageName, File::get(request()->file('img')));
        }else{
            $imageName = 'user_default.png';
        }
        
        User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'gender' => $data['gender'],
            'nick' => $data['nick'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'img' => $imageName ,
            'type' => $data['type'],
        ]);

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

        return $last_user;

    }
}
