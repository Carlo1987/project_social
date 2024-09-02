@extends('layouts.app')

@section('content')

<div class="container">
@if($friend_requests->count() > 0 || $friendships->count() > 0)

<div class="w-100 d-flex flex-row justify-content-center mb-1">
  <div class="container_titles">
     <h4 class="title_general"> 
        <span class="lang" data-section="profile" data-article="notifications"> Notifiche </span> 
    </h4> 
  </div>
</div>



    <div class="content_search">

        @foreach($friend_requests as $friendship)

        <div class="content_search_row px-1">   
                <a href="{{ route('users.show', ['user'=> $friendship->user->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $friendship->user->img]) }}" alt="friend_img">
                    </div>

                    <div> {{ $friendship->user->name }} </div>
                    <div> {{ $friendship->user->surname }} </div>
                </a>
   
                @include('friendship.button_search')
        </div>

        @endforeach

        @foreach($friendships as $friendship)

        <div class="content_search_row px-1">   
                <a href="{{ route('users.show', ['user'=> $friendship->friend->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $friendship->friend->img]) }}" alt="friend_img">
                    </div>

                    <div> {{ $friendship->friend->name }} </div>
                    <div> {{ $friendship->friend->surname }} </div>
                </a>
   
                @include('friendship.button_search')
        </div>

        @endforeach
    </div>
@else

        <div class="alert {{ Themes::show() }} mt-3">
                <h3 class="lang" data-section="profile" data-article="no_friendship">Non è presente nussuna richiesta</h3>
        </div>
@endif
 
</div>


@endsection

