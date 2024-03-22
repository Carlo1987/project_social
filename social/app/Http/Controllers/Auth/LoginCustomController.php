<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginCustomController extends Controller
{
    
      function login(Request $request){

        $request->validate([
            'email' => ['required','email']
     ],
    [
     'email.required' => "Campo obbligatorio",
     'email.email' => "Inserire una email valida",
    ]);

    $user = User::where('email',$request->input('email'))->first();

    if(!$user){
      return redirect()->back()->withErrors(['email'=>'Utente non trovato']);
    }else{
        if(!Hash::check($request->input('password'),$user->password)){
            return redirect()->back()->withErrors(['password'=>'Password errata']);
        }else{
 
            Auth::login($user);
            return redirect()->route('welcome');
        }
    
    }
    }

}
