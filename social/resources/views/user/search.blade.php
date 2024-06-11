@extends('layouts.app')

@section('content')

- <div class="container"> 
    @if($users->count() > 0)
    <div class="content_search">
        @foreach($users as $user)

        <div class="content_search_row px-1">   
                <a href="{{ route('users.show', ['user'=> $user->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $user->img]) }}" alt="friend_img">
                    </div>

                    <div> {{ $user->name }} </div>
                    <div> {{ $user->surname }} </div>
                    <div class="user_nick"> {{ '@'.$user->nick }} </div>
                </a>
        </div>

     @endforeach
     </div>
     @endif

     @if($users->count() == 0)
         <div class="alert alert-danger fs-3 text-center w-100" role="alert">
            <p class="lang" data-section="nav" data-article="no_found">Nessun Utente trovato</p>
         </div>
    @endif
     

</div> 


@endsection