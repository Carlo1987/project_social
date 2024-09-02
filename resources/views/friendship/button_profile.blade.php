                                    <!--  PROFILO UTENTE LOGGATO  -->
@if($user->id == Auth::user()->id)   

@if( Friendships::count() > 0)
<div class="dropup-center dropup">
    <button class="btn btn-primary dropdown-toggle position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" >  
       <span class="lang" data-section="profile" data-article="questions">richieste</span>   ({{ Friendships::count() }})
    </button>
   
    <ul class="menu_friendships dropdown-menu position-absolute bottom-100">
        @foreach($friend_requests as $friend_request)

        @if( Friendships::status($friend_request, 'in sospeso') )
        <li>
            <form action="{{ route('friendships.index') }}" method="GET">
                @csrf
                <input type="hidden" value="{{ $user->id }}" name="friend">
                <button type="submit" class="dropdown-item text-success" > <span class="lang" data-section="profile" data-article="firendship_from">Richiesta da </span> {{ $friend_request->user->name .' '. $friend_request->user->surname }}</button>
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
                <button type="submit" class="dropdown-item text-primary" > <span class="lang" data-section="profile" data-article="friendship_to">Richiesta per </span> {{ $friendship->friend->name .' '. $friendship->friend->surname }} </button>
            </form>
        </li>
        @endif

    @endforeach
    </ul>
</div>

@else     <!--  se non ci sono richieste di amicia -->

    <button class="btn btn-primary" type="button" style="width: 120px;">
        <span class="lang" data-section="profile" data-article="questions">richieste </span> (0)
    </button>

@endif<!--  fine profilo utente loggato  -->



@else                           <!--   PROFILO ALTRI UTENTI    -->


<!-- se il seguente utente ha ricevuto una richiesta di amicizia dall'utente loggato...   -->
@if( Friendships::checkFriendship( $friendships , $user->id) != false &&  Friendships::checkFriendship( $friendships , $user->id) == 'accettata') 
<!-- se la richiesta è stata accettata.... -->
     @include('friendlist.button_friend_profile')   <!-- bottone amicizia / o per elimminare amicizia-->

@elseif( Friendships::checkFriendship( $friendships , $user->id) != false &&  Friendships::checkFriendship( $friendships , $user->id) == 'in sospeso') 
<!-- se la richiesta è ancora in sospeso.... -->
<button class="btn btn-warning  lang" data-section="profile" data-article="delete_friendship" style="width: 165px;">
   In attesa di risposta
</button>


 <!-- se il seguente utente ha mandato una richiesta di amicizia all'utente loggato...   -->
@elseif( Friendships::checkFriend_request( $friend_requests , $user->id) != false &&  Friendships::checkFriend_request( $friend_requests , $user->id) == 'accettata' )
  <!-- se la richiesta è stata accettata.... -->
    @include('friendlist.button_friend_profile')    <!-- bottone amicizia / o per elimminare amicizia-->

@elseif( Friendships::checkFriend_request( $friend_requests , $user->id) != false &&  Friendships::checkFriend_request( $friend_requests , $user->id) == 'in sospeso') 
<!-- se la richiesta è ancora in sospeso.... -->
<button class="answer_friend btn btn-warning lang" data-section="profile" data-article="answer_friendship" style="width: 180px;">
     Rispondi alla richiesta 
</button>

@elseif( Friendships::checkFriend_request( $friend_requests , $user->id) == false &&   Friendships::checkFriendship( $friendships , $user->id) == false  ) 
<!--  se non c'è nessuna richiesta di amicizia   -->

<form action="{{ route('friendships.store') }}" method="POST">
    @csrf
    <input type="hidden" value="{{ Auth::user()->id }}" name="user">
    <input type="hidden" value="{{ $user->id }}" data-friend="{{ $user->id }}" class="friend_ID" name="friend">
    <button class="button_friendship btn btn-primary lang" data-theme="{{ Themes::show() }}" data-section="profile" data-article="question_friendship"  style="width: 150px;"> Richiedi amicia </button>
</form>

@endif

@endif







