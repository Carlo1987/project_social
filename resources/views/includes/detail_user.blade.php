<div class="user_index">

    @if(isset($type) && $type == 'image')

    <img src="{{ route('getAvatar', ['avatar' => $image->user->img]) }}" alt="user_image">

    <div class="container_index_user">
        <a href="{{ route('users.show', ['user'=> $image->user->id]) }}">
            {{ '@'.$image->user->nick }}
        </a>
    </div>

    @else

    <img src="{{ route('getAvatar', ['avatar' => $video->user->img]) }}" alt="user_video">

    <div class="container_index_user">
        <a href="{{ route('users.show', ['user'=> $video->user->id]) }}">
            {{ '@'.$video->user->nick }}
        </a>
    </div>

    @endif


    <div class="container_menu_detail">

        @if(isset($image) && $image->user->id == Auth::user()->id || isset($video) && $video->user->id == Auth::user()->id)

        <i class="fa fa-bars fa-lg menu_detail_image" aria-hidden="true" style="cursor:pointer;"></i>

            <ul class="menu_detail">
                <li> <a href="{{ url()->previous() }}" class="detail_back lang" data-section="profile" data-article="back"> Torna indietro </a> </li>

                @if(isset($image))
                <li class="destroy_file lang" data-id="{{ $image->id }}" data-type="image" style="cursor:pointer;" data-section="profile" data-article="delete_file"> <a href="#"> Elimana file </a></li>
                @elseif(isset($video))
                <li class="destroy_file lang" data-id="{{ $video->id }}" data-type="video" style="cursor:pointer;" data-section="profile" data-article="delete_file"> <a href="#"> Elimana file</a> </li>
                @endif
            </ul>

        @else

        <a href="{{ url()->previous() }}">
            <i class="fa fa-times fa-lg" aria-hidden="true" style="cursor: pointer;"> </i>
        </a>
        @endif

    </div>

</div>