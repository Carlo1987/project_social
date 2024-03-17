<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class RealLoginController extends Controller
{
    
    public function login(Request $request){
        $message_empty_field = 'Questo campo è obbligatorio';
        $request->validate([
            'email'=> ['required','email'],
            'password'=>['required']
        ],
    [
        'email.required' =>  $message_empty_field,
        'email.email'=> 'Inserire una email valida',
        'password.required' =>  $message_empty_field
    ]);

    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        return redirect()->intended('dashboard');
    }

    return back()->withError('email o password sono errati, riprovare');
    }
   

}
