<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   //   aggiunto per usare Auth (utente identificato)
use Illuminate\Support\Facades\Storage; // aggiunto per usare Storage per le immagini
use Illuminate\Support\Facades\File; // aggiunto per usare file per le immagini
use Illuminate\Http\Response;  //  aggiunto per prendere img da storage

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }


    /////////////   CREARE UNA NUOVA IMMAGINE   ////////////////

    public function create()
    {
        return view('image.create');
    }


    public function store(Request $request)
    {
        $text_validate = json_decode($request->input('text_validate'),true);

        $request->validate([
            'img' => ['mimes:jpeg,jpg,png,gif,webp', 'required'],
            'description' => ['string' , 'required'],
        ],
         [
            "description.string" =>  $text_validate['invalid_format'],
            "description.required" =>  $text_validate['field_required'],
             "img.required" => $text_validate['no_file'],
             "img.mimes" =>  $text_validate['invalid_format'],
         ]);

        $img = $request->file('img');
        $image_name = time() . $img->getClientOriginalName();
        Storage::disk('images')->put($image_name, File::get($img));

        $description = $request->input('description');

        $images = new Image();
        $images->name = $image_name;
        $images->user_id = Auth::user()->id;
        $images->description = $description;

        $images->save();

        return redirect()->route('users.show', ['user' => Auth::id()])->with(['message' => $text_validate['add_image']]);
    }


    /////////////   VISUALIZZARE UN' IMMAGINE CON response  ////////////////

    public function show(Image $image)
    {
        $file = Storage::disk('images')->get($image->name);
        $type = Storage::mimeType($file); 

        $response = new Response($file, 200);
        return $response->header('Content-Type', $type); 
    }


    /////////////   MOSTRARE UN' IMMAGINE NEL DETTAGLIO  ////////////////

    public function detail($id)
    {
        $image = Image::find($id);
        $others_images = Image::where('user_id', $image->user_id)->where('id', '!=', $id)->get();
        return view('image.detail', [
            'image' => $image,
            'others_images' => $others_images
        ]);
    }


    /////////////   CANCELLARE UN' IMMAGINE   ////////////////

    public function delete($id)
    {
        $image = Image::find($id);

        Storage::disk('images')->delete($image->name);

        if (count($image->comments) > 0) {
            foreach ($image->comments as $comment) {
                $comment->delete();
            }
        }

        if (count($image->likes) > 0) {
            foreach ($image->likes as $like) {
                $like->delete();
            }
        }

        $image->delete();

        $last_image = Image::where('user_id', $image->user_id)->max('id');

        return response()->json([
            'last_file' => $last_image,
        ]);
    }
}
