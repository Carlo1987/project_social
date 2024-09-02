<?php

namespace App\Helpers;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class isLike{

    public static function checkImage($id){
        $result = false;
        $like_count = Like::where('image_id',$id)->where('user_id',Auth::user()->id)->count();
        if($like_count != 0){
            $result = true;
        }
        return $result;
    }


    public static function checkVideo($id){
        $result = false;
        $like_count = Like::where('video_id',$id)->where('user_id',Auth::user()->id)->count();
        if($like_count != 0){
            $result = true;
        }
        return $result;
    }
}