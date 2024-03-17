@extends('layouts.app')

@section('content')

<div class="container">
@if($friend_requests->count() > 0 || $friendships->count() > 0)
    <div class="content_search  {{ Themes::show(Auth::user()->id) }}">

   
        @foreach($friend_requests as $friendship)
        <div class="row d-flex flex-row align-items-center border-bottom border-dark">
            <div class="col-lg-7 col-md-8">
                <a href="{{ route('users.show', ['user'=> $friendship->user->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $friendship->user->img]) }}" alt="friend_img" style="width: 60px; height: 55px; border-radius: 50px;">
                    </div>

                    <div> {{ $friendship->user->name }} </div>
                    <div> {{ $friendship->user->surname }} </div>
                    <div> {{ '@'.$friendship->user->nick }} </div>
                </a>
            </div>

            <div class="col-lg-5 col-md-4 pb-md-0 pb-2 offset-md-0 offset-2">
                @include('friendship.button_search')
            </div>
        </div>
        @endforeach

        @foreach($friendships as $friendship)
        <div class="row d-flex flex-row align-items-center border-bottom border-dark">
            <div class="col-lg-7 col-md-8">      
                <a href="{{ route('users.show', ['user'=> $friendship->friend->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $friendship->friend->img]) }}" alt="friend_img" style="width: 60px; height: 55px; border-radius: 50px;">
                    </div>

                    <div> {{ $friendship->friend->name }} </div>
                    <div> {{ $friendship->friend->surname }} </div>
                    <div> {{ '@'.$friendship->friend->nick }} </div>
                </a>
            </div>

            <div class="col-lg-5 col-md-4 pb-md-0 pb-2 offset-md-0 offset-2">      
                @include('friendship.button_search')
            </div>
        </div>
    </div>
        @endforeach

@else

        <div class="alert {{ Themes::show(Auth::user()->id) }} mt-3">
                <h3>Non è presente nussuna richiesta</h3>
        </div>
@endif
 
</div>


@endsection