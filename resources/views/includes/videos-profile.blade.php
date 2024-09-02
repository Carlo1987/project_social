@if ($videos->count() == 0)
<div class="alert alert-light w-100 mt-3 fs-4 text-center">
    @if($user->id == Auth::user()->id)
       <span class="lang" data-section="profile" data-article="no_videos_auth"> Che aspetti??? aggiungi qualche video dentro il tuo profilo!!! Clicca </span>
    <a href="{{ route('videos.create') }}" class="lang" data-section="profile" data-article="link">qui</a>
    @else
       <span class="lang" data-section="profile" data-article="no_videos_user"> Questo Utente non ha ancora caricato nessun video!!</span>
    @endif
</div>
@else
    @include('video.index_videos')
@endif