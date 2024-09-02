@extends('layouts.app')

@section('content')


<div class="w-100 d-flex flex-row justify-content-center">
  <div class="container_titles">
     <h4 class="title_general lang" data-section="profile" data-article="search"> Risultati </h4>
  </div>
</div>


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