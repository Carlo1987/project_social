<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Models\User;

class CookieController extends Controller
{

    private $time = 60*24*7;


    public function setCookie($id)
    {
        $cookie = Cookie::make('auth' , $id , $this->time);
        return $cookie;
    }


    
    public function getCookie() :void
    {
        $cookie = request()->cookie('auth');

        if($cookie && !Auth::check()){
                $user = User::where('id' , $cookie)->first();
            
                Auth::login($user);
        }
    }



    public function deleteCookie()
    {
        $cookie = Cookie::make('auth' , null , -$this->time);
        return $cookie;
    }
}
