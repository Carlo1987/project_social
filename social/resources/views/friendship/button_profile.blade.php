                                    <!--  PROFILO UTENTE LOGGATO  -->
@if($user->id == Auth::user()->id)   

@if( Friendships::count() > 0)
<div class="dropup-center dropup">
    <button class="btn btn-primary dropdown-toggle position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ Friendships::count() }} richieste in sospeso
    </button>
   
    <ul class="menu_friendships dropdown-menu position-absolute bottom-100">
        @foreach($friend_requests as $friend_request)

        @if( Friendships::status($friend_request, 'in sospeso') )
        <li>
            <form action="{{ route('friendships.index') }}" method="GET">
                @csrf
                <input type="hidden" value="{{ $user->id }}" name="friend">
                <input type="submit" class="dropdown-item text-success" value="Richiesta da {{ $friend_request->user->name .' '. $friend_request->user->surname }}">
            </form>
        </li>
        @endif

        @endforeach

        @foreach($friendships as $friendship)

        @if( Friendships::status($friendship, 'in sospeso') )
        <li>
            <form action="{{ route('friendships.index') }}" method="GET">
                @csrf
                <input type="hidden" value="{{ $user->id }}" name="friend">
                <input type="submit" class="dropdown-item text-primary" value="Richiesta per {{ $friendship->friend->name .' '. $friendship->friend->surname }}" >
            </form>
        </li>
        @endif

    @endforeach
    </ul>
</div>

@else     <!--  se non ci sono richieste di amicia -->

    <button class="btn btn-primary" type="button" style="width: 170px;">
        0 richieste in sospeso
    </button>

@endif<!--  fine profilo utente loggato  -->



@else                           <!--   PROFILO ALTRI UTENTI    -->


<!-- se il seguente utente ha ricevuto una richiesta di amicizia dall'utente loggato...   -->
@if( Friendships::checkFriendship( $friendships , $user->id) != false &&  Friendships::checkFriendship( $friendships , $user->id) == 'accettata') 
<!-- se la richiesta è stata accettata.... -->
     @include('friendlist.button_friend_profile')   <!-- bottone amicizia / o per elimminare amicizia-->

@elseif( Friendships::checkFriendship( $friendships , $user->id) != false &&  Friendships::checkFriendship( $friendships , $user->id) == 'in sospeso') 
<!-- se la richiesta è ancora in sospeso.... -->
<button class="btn btn-warning  w-100">
    <form action="{{ route('friendship.delete', ['id'=> $user->id]) }}" method="GET">
        @csrf
        <input type="submit" class="dropdown-item" value="Annulla richiesta">
    </form>
</button>


 <!-- se il seguente utente ha mandato una richiesta di amicizia all'utente loggato...   -->
@elseif( Friendships::checkFriend_request( $friend_requests , $user->id) != false &&  Friendships::checkFriend_request( $friend_requests , $user->id) == 'accettata' )
  <!-- se la richiesta è stata accettata.... -->
    @include('friendlist.button_friend_profile')    <!-- bottone amicizia / o per elimminare amicizia-->

@elseif( Friendships::checkFriend_request( $friend_requests , $user->id) != false &&  Friendships::checkFriend_request( $friend_requests , $user->id) == 'in sospeso') 
<!-- se la richiesta è ancora in sospeso.... -->
<button class="btn btn-warning w-100">
   <form action="{{ route('friendships.index') }}" method="GET">
        @csrf
        <input type="submit" class="dropdown-item" value="Rispondi alla richiesta">
    </form>
</button>

@elseif( Friendships::checkFriend_request( $friend_requests , $user->id) == false &&   Friendships::checkFriendship( $friendships , $user->id) == false  ) 
<!--  se non c'è nessuna richiesta di amicizia   -->

<form action="{{ route('friendships.store') }}" method="POST">
    @csrf
    <input type="hidden" value="{{ Auth::user()->id }}" name="user">
    <input type="hidden" value="{{ $user->id }}" data-friend="{{ $user->id }}" class="friend_ID" name="friend">
    <input type="submit" class="button_friendship w-100 btn btn-primary" data-theme="{{ Themes::show(Auth::user()->id) }}" value="Richiedi amicizia">
</form>
@endif

@endif