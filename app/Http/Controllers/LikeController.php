<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;   //   aggiunto per usare Auth (utente identificato)


class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);  
    }

////////////      CREARE LIKE PER UN' IMMAGINE   ////////////

    public function like_image($image_id)
    {
        $like = new Like();

        $like->user_id = Auth::user()->id;
        $like->image_id = (int)$image_id;
        $like->video_id = null;

        $like->save();

        return response()->json([
            'user_img' => $like->user->img,
            'user_id' => $like->user->id,
            'user_nick' => $like->user->nick,
        ]);
    }


   
    ////////////      CREARE LIKE PER UN VIDEO   ////////////

    public function like_video($video_id)
    {
        $like = new Like();

        $like->user_id = Auth::user()->id;
        $like->image_id = null;
        $like->video_id = $video_id;

        $like->save();

        return response()->json([
            'user_img' => $like->user->img,
            'user_id' => $like->user->id,
            'user_nick' => $like->user->nick,
        ]);
    }


     ////////////      ELIMINARE LIKE PER UN' IMMAGINE   ////////////

     public function dislike_image($image_id)
     {
         $user = Auth::user();
 
         $like = Like::where('user_id', $user->id)
             ->where('image_id', $image_id)
             ->first();

        $nick =  $like->user->nick;
  
         $like->delete();
 
         return response()->json([
             'file' => $image_id,
             'nick' => $nick
         ]);
     }

    ////////////      ELIMINARE LIKE PER UN VIDEO   ////////////

    public function dislike_video($video_id)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)
            ->where('video_id', $video_id)
            ->first();

        $nick =  $like->user->nick;

        $like->delete();

        return response()->json([
            'file' => $video_id,
            'nick' => $nick,
        ]);
    }
}
