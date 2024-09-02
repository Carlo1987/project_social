<div class="like">
    @if( isLike::checkVideo($video->id) == true )
    <img src="{{ asset('img/red_heart.png') }}" alt="like" id="heart" class="like_video" data-id="{{ $video->id }}">
    @include('like.likes_Video_count')
    @else
    <img src="{{ asset('img/black_heart.png') }}" alt="dislike" id="heart" class="dislike_video" data-id="{{ $video->id }}">
    @include('like.likes_Video_count')
    @endif
</div>

