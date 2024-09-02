@if($images->count() == 0)
<div class="alert alert-light mt-3">
    @if($user->id == Auth::user()->id)
      <span class="lang" data-section="profile" data-article="no_images_auth">Che aspetti??? aggiungi qualche immagine dentro il tuo profilo!!! Clicca </span> 
    <a href="{{ route('images.create') }}" class="lang" data-section="profile" data-article="link">qui</a>
    @else
      <span class="lang" data-section="profile" data-article="no_images_user"> Questo Utente non ha ancora caricato nessuna immagine!!</span>
    @endif
</div>
@else
   @include('image.index_images')
@endif