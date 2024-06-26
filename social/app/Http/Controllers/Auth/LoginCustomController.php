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
        $text_validate = json_decode($request->input('text_validate'),true);

        $request->validate([
            'email' => ['required','email']
     ],
    [
        'email.required' => $text_validate['field_required'],
        'email.email' => $text_validate['email_invalid'],
       ]);
 
    $user = User::where('email',$request->input('email'))->first();

    if(!$user){
      return redirect()->back()->withErrors(['email'=>$text_validate['user_notFound']]);
    }else{
        if(!Hash::check($request->input('password'),$user->password)){
            return redirect()->back()->withErrors(['password'=>$text_validate['password_wrong']]);
        }else{
 
            Auth::login($user);
            return redirect()->route('welcome');
        }
    
    }
    }

}
