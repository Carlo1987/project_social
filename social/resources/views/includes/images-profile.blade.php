@if($images->count() == 0)
<div class="alert alert-light mt-3">
    @if($user->id == Auth::user()->id)
       Che aspetti??? aggiungi qualche immagine dentro il tuo profilo!!!
    <a href="{{ route('images.create') }}">Clicca qui!</a>
    @else
       Questo Utente non ha ancora caricato nessuna immagine!!
    @endif
</div>
@else
   @include('image.index_images')
@endif