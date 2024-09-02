<?php

namespace App\Helpers;
use App\Models\Friendlist;
use Illuminate\Support\Facades\Auth;

class isFriend{

    public static function check($id){
        $result = false;
        if($id != Auth::user()->id){
            $friendlistsUserRequest_count = Friendlist::where('user_id',Auth::user()->id)->where('friend_id',$id)->count();
            $friendlistsFriendRequest_count = Friendlist::where('user_id',$id)->where('friend_id',Auth::user()->id)->count();
            if($friendlistsUserRequest_count != 0 || $friendlistsFriendRequest_count != 0){
                $result = true;
            }
        }
      
        return $result;
    }
}