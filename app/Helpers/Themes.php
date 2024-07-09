<?php

namespace App\Helpers;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class Themes{

      public static function show(){
            $result = 'default';
            if(Auth::check()){
                  $theme = Theme::where('user_id',Auth::user()->id)->first();
                  $result = $theme->theme;
            } 
          
            return $result;          
      }

}