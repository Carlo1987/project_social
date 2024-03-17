<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   //   aggiunto per usare Auth (utente identificato)
use Illuminate\Support\Facades\Storage; // aggiunto per usare Storage per le immagini
use Illuminate\Support\Facades\File; // aggiunto per usare file per le immagini
use Illuminate\Http\Response;  //  aggiunto per prendere img da storage

class VideoController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth' , 'verified']);   //  middleware per limitare l'accesso se non si è loggati o se non si ha fatto la verifica
    }



    /////////////   CREARE UN NUOVO VIDEO   ////////////////

    public function create()
    {
        return view('video.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'video' => 'mimes:mp4,mov,ogg',
            'description' => 'string',
        ]);

        $video = $request->file('video');
        $video_name = time() . $video->getClientOriginalName();
        Storage::disk('videos')->put($video_name, File::get($video));

        $videos = new Video();
        $videos->user_id = Auth::user()->id;
        $videos->name = $video_name;
        $videos->description = $request->input('description');

        $videos->save();

        return redirect()->route('users.show', ['user' => Auth::id()])->with(['message' => 'Video aggiunto correttamente']);
    }



    /////////////   VISUALIZZARE UN VIDEO CON response  ////////////////

    public function show(Video $video)
    {
        $file = Storage::disk('videos')->get($video->name);
        return new Response($file, 200);
    }



    /////////////   MOSTRARE UN VIDEO NEL DETTAGLIO  ////////////////

    public function detail($id)
    {
        $video = Video::find($id);
        $others_videos = Video::where('user_id', $video->user_id)->where('id', '!=', $id)->get();
        return view('video.detail', [
            'video' => $video,
            'others_videos' => $others_videos
        ]);
    }



    /////////////   CANCELLARE UN VIDEO   ////////////////

    public function delete($id)
    {
        $video = Video::find($id);

        Storage::disk('videos')->delete($video->name);

        if (count($video->comments) > 0) {
            foreach ($video->comments as $comment) {
                $comment->delete();
            }
        }

        if (count($video->likes) > 0) {
            foreach ($video->likes as $like) {
                $like->delete();
            }
        }

        $video->delete();

        $last_video = Video::where('user_id', $video->user_id)->max('id');

        return response()->json([
            'last_video' => $last_video,
        ]);
    }
}
