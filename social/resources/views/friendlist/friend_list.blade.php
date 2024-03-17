@extends('layouts.app')

@section('content')

@if($user->id == Auth::user()->id || $user->type == 'public' || isFriend::check($user->id)) 
<div class="container">
    <div class="content_search {{ Themes::show(Auth::user()->id) }}">

        @if($friendlists->count() > 0) <!--  se ci sono amici .... -->

        @foreach($friendlists as $friend)

        @if($friend->user_id == $user->id)
        <div class="row d-flex flex-row align-items-center border-bottom border-dark">
            <div class="col-lg-7 col-md-9">
                <a href="{{ route('users.show', ['user'=> $friend->friend->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $friend->friend->img]) }}" alt="friend_img"  style="width: 60px; height: 55px; border-radius: 50px;">
                    </div>

                    <div> {{ $friend->friend->name }} </div>
                    <div> {{ $friend->friend->surname }} </div>
                    <div> {{ '@'.$friend->friend->nick }} </div>
                </a>
            </div>

            <div class="col-lg-5 col-md-2 pb-md-0 pb-2 offset-md-0 offset-2">
                @include('friendlist.button_list_friends')    <!--  bottone  amicizia / o per eliminare amicizia -->
            </div>
        </div>

        @elseif($friend->friend_id == $user->id)
        <div class="row d-flex flex-row align-items-center border-bottom border-dark">
            <div class="col-lg-7 col-md-9">
                <a href="{{ route('users.show', ['user'=> $friend->user->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $friend->user->img]) }}" alt="friend_img" style="width: 60px; height: 55px; border-radius: 50px;">
                    </div>

                    <div> {{ $friend->user->name }} </div>
                    <div> {{ $friend->user->surname }} </div>
                    <div> {{ '@'.$friend->user->nick }} </div>
                </a>
            </div>

            <div class="col-lg-5 col-md-2 pb-md-0 pb-2 offset-md-0 offset-2">
                  @include('friendlist.button_list_friends')    <!--  bottone  amicizia / o per eliminare amicizia -->
            </div>  
        </div>
        @endif

        @endforeach

        @else <!--  se non ci sono ancora amici ....  -->

                <div class="alert {{ Themes::show(Auth::user()->id) }}">
                    Non sono ancora presenti amici
                </div>

        @endif
    </div>
</div>
@else        <!--  se il profilo è privato e non si è amici.... -->
   <div class="alert {{ Themes::show(Auth::user()->id) }}">
    <h3>Questo Utente ha un profilo privato, richiedi la sua amicizia se vuoi vedere la sua lista di amici, clicca <a href="{{ url()->previous() }}">qui</a> per tornare indietro</h3>
   </div>
@endif

@endsection