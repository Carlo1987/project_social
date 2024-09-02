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
        $this->middleware(['auth']);  
    }



    /////////////   CREARE UN NUOVO VIDEO   ////////////////

    public function create()
    {
        return view('video.create');
    }


    public function store(Request $request)
    {
        $text_validate = json_decode($request->input('text_validate'),true);

       $request->validate([
            'description' => ['string' , 'required'],
            'video'=> ['mimes:mp4,mov,ogg,qt' , 'required'],
        ],
        [
           "description.string" =>  $text_validate['invalid_format'],
           "description.required" =>  $text_validate['field_required'],
            "video.required" => $text_validate['no_file'],
            "video.mimes" =>  $text_validate['invalid_format'],
        ]);


        $video = $request->file('video');
        $video_name = time() . $video->getClientOriginalName();
        Storage::disk('videos')->put($video_name, File::get($video));

        $videos = new Video();
        $videos->user_id = Auth::user()->id;
        $videos->name = $video_name;
        $videos->description = $request->input('description');

        $videos->save();

        return redirect()->route('users.show', ['user' => Auth::id()])->with(['message' => $text_validate['add_video']]);
    }



    /////////////   VISUALIZZARE UN VIDEO CON response  ////////////////

    public function show(Video $video)
    {
        $file = Storage::disk('videos')->get($video->name);
        $type = Storage::mimeType($file); 

        $response = new Response($file, 200);
        return $response->header('Content-Type', $type); 
  
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
            'last_file' => $last_video,
        ]);
    }
}
