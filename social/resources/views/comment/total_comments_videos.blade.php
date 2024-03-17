<div class="comments_total button_query_video">
    <a href="{{ route('video.detail', ['id' => $video->id]) }}" class="button_comments btn btn-warning fs-5" data-type="video" data-theme="{{ Themes::show(Auth::user()->id) }}">
        Commenti totali({{ count($video->comments) }})
    </a>
</div>