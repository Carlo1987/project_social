@extends('layouts.app')

@section('content')

<div class="w-100 d-flex flex-row justify-content-center mb-1">
  <div class="container_titles">
     <h4 class="title_general"> 
        <span class="lang" data-section="profile" data-article="list_friends"> Lista amici </span> 
        {{ $user->name }}
    </h4> 
  </div>
</div>



@if($user->id == Auth::user()->id || $user->type == 'public' || isFriend::check($user->id))
<div class="container">
    <div class="content_search">

        @if($friendlists->count() > 0) <!--  se ci sono amici .... -->

        @foreach($friendlists as $friend)

        @if($friend->user_id == $user->id)

        <div class="content_search_row px-1">   
                <a href="{{ route('users.show', ['user'=> $friend->friend->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $friend->friend->img]) }}" alt="friend_img">
                    </div>

                    <div> {{ $friend->friend->name }} </div>
                    <div> {{ $friend->friend->surname }} </div>
                </a>
   
                @include('friendlist.button_list_friends') <!--  bottone  amicizia / o per eliminare amicizia -->
        </div>


        @elseif($friend->friend_id == $user->id)

        <div class="content_search_row px-1">   
                <a href="{{ route('users.show', ['user'=> $friend->user->id]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $friend->user->img]) }}" alt="friend_img">
                    </div>

                    <div> {{ $friend->user->name }} </div>
                    <div> {{ $friend->user->surname }} </div>
                </a>
   
                @include('friendlist.button_list_friends') <!--  bottone  amicizia / o per eliminare amicizia -->
        </div>

        @endif

        @endforeach

        @else <!--  se non ci sono ancora amici ....  -->

        <div class="alert {{ Themes::show() }} lang" data-section="profile" data-article="no_friends">
            Non sono ancora presenti amici
        </div>

        @endif
    </div>
</div>
@else <!--  se il profilo è privato e non si è amici.... -->
<div class="alert {{ Themes::show() }}">
    <h3>
        <span class="lang" data-section="profile" data-article="noFriend_private">Questo Utente ha un profilo privato, richiedi la sua amicizia se vuoi vedere la sua lista di amici, per tornare indietro clicca </span>
        <a href="{{ url()->previous() }}" class="lang" data-section="profile" data-article="link">qui</a>
    </h3>
</div>
@endif

@endsection