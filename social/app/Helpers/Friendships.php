<?php

namespace App\Helpers;

use App\Models\Friendship;
use App\Models\FriendList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Friendships
{

    public static function count()
    {
        $id = Auth::user()->id;
            $count_friendships = DB::table('friendships')->where('user_id', $id)->where('status', 'in sospeso')->count();
            $count_friend_requests = DB::table('friendships')->where('friend_id', $id)->where('status', 'in sospeso')->count();

            return $count_friendships + $count_friend_requests;
        
    }


    public static function status($element, $status)
    {
        if ($element->status == $status) {
            return true;
        } else {
            return false;
        }
    }


    public static function checkFriendship($elements, $id)
    {
        $result = false;
        foreach ($elements as $element) {
            if ($element->friend_id == $id) {
                $result = $element->status;
            }
        }
        return $result;
    }


    public static function checkFriend_request($elements, $id)
    {
        $result = false;
        foreach ($elements as $element) {
            if ($element->user_id == $id) {
                $result = $element->status;
            }
        }
        return $result;
    }



}
