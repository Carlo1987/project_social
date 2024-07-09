<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   //   aggiunto per usare Auth (utente identificato)
use Illuminate\Support\Facades\DB;   //   da aggiungere se avessi usato proprietà DB del database

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);   
    } 

   ////////////////     CREARE UN COMMENTO   ///////////////////////
  
    public function store(Request $request)
    {
        $comment = new Comment();

        $request->validate([
            'file_id' => 'integer',
            'comment' => 'string'
        ]);

        $comment->user_id =  Auth::user()->id;
        $comment->comment =   $request->input('comment');

       if($request->input('type') == 'video'){
     
            $comment->image_id =  null;
            $comment->video_id = $request->input('file_id');
       
        }else{
            
            $comment->image_id =  $request->input('file_id');
            $comment->video_id = null;
        }

        $comment->save();
       
         $url = url()->previous(); 
        return redirect($url);     
    } 


      ////////////////     MODIFICARE UN COMMENTO   ///////////////////////

    public function edit(Comment $comment) {
       return view('comment.edit', ['comment' => $comment]);
    }


    public function update(Request $request, Comment $comment) {
        $request->validate([
            'comment' => 'string',
        ]);

        $new_comment = $request->input('comment');
        $comment->comment = $new_comment;
        $comment->save();

        return redirect($request->input('url')); 
    }

   ////////////////     CANCELLARE UN COMMENTO   ///////////////////////

    public function delete($id){
        $comment = Comment::find($id);
        $comment->delete();

        $url = url()->previous(); 
        return redirect($url); 
    }




}
