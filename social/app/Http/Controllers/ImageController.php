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
        $this->middleware(['auth' , 'verified']);   //  middleware per limitare l'accesso se non si è loggati o se non si ha fatto la verifica
    }


    /////////////   CREARE UNA NUOVA IMMAGINE   ////////////////

    public function create()
    {
        return view('image.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'img' => 'image',
            'description' => 'string',
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

        return redirect()->route('users.show', ['user' => Auth::id()])->with(['message' => 'Immagine aggiunta correttamente']);
    }


    /////////////   VISUALIZZARE UN' IMMAGINE CON response  ////////////////

    public function show(Image $image)
    {
        $file = Storage::disk('images')->get($image->name);
        return new Response($file, 200);
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
            'last_image' => $last_image,
        ]);
    }
}
