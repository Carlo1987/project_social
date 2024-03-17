@extends('layouts.app')

@section('content')

<div class="container">
    @if($users->count() > 0)
    <div class="content_search  {{ Themes::show(Auth::user()->id) }}">
        @foreach($users as $user)
        <div class="user_found">

            <div style="min-width: 500px">
                <a href="{{ route('users.show', ['user'=> $user->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $user->img]) }}" alt="user_img" style="width: 60px; height: 55px; border-radius: 50px;">
                    </div>

                    <div> {{ $user->name }} </div>
                    <div> {{ $user->surname }} </div>
                    <div> {{ '@'.$user->nick }} </div>
                </a>
            </div>

        </div>
     @endforeach
     </div>
     @endif

     @if($users->count() == 0)
         <div class="alert alert-danger fs-3 text-center w-100" role="alert">
            <p>Nessun Utente trovato</p>
         </div>
    @endif
     

</div>


@endsection