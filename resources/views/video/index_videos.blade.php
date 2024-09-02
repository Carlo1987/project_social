@foreach($videos as $video)

@if( $video->user->type == 'public' || isFriend::check($video->user->id) || $user->id == Auth::user()->id )

<div class="card card_files w-100 rounded-4">

    <div class="user_index">

        <img src="{{ route('getAvatar', ['avatar' => $video->user->img]) }}" alt="user_video">

        <div class="container_index_user">
            <a href="{{ route('users.show', ['user'=> $video->user->id]) }}">
                <span class="user_nick">{{ $video->user->name  .' '. $video->user->surname .' - '}}</span> {{ '@'.$video->user->nick }}
            </a>
        </div>

    </div>

    <a href="{{ route('video.detail', ['id' => $video->id]) }}" class="file_index">
        <video class="video" controls>
            <source src="{{ route('videos.show', ['video'=> $video->id]) }}">
        </video>
    </a>

    <div class="card-body mb-2 border-bottom border-dark">
        <p class="card-text fs-3 text-center"> {{ $video->description }} </p>
    </div>

    <div class="like_content">
        @include('like.like_videos')
        @include('comment.total_comments_videos')
    </div>

    <div class="mt-2">
        @include('comment.comments_videos')
    </div>

</div>

@endif

@endforeach