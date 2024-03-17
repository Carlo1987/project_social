<?php

namespace App\Helpers;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class Themes{

      public static function show($id){
            $theme = Theme::where('user_id',$id)->first();
            return $theme->theme;        
      }

}