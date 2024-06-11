<div class="like">
    @if( isLike::checkImage($image->id) == true )
    <img src="{{ asset('img/red_heart.png') }}" alt="like" id="heart" class="like_image" data-id="{{ $image->id }}">
    @include('like.likes_Image_count')
    @else
    <img src="{{ asset('img/black_heart.png') }}" alt="dislike" id="heart" class="dislike_image" data-id="{{ $image->id }}">
     @include('like.likes_Image_count')
    @endif
</div>

