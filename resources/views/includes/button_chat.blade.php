
@if($user->id != Auth::id())            <!--  se ci si trova sul profilo di un altro utente....   -->

<div class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasChat_{{ $chat['friend_id'] }}" aria-controls="offcanvasChat_{{ $chat['friend_id'] }}" style="cursor: pointer;">

<i class="fa-solid fa-envelope fa-2xl button_chat"data-friend="{{ $chat['friend_id'] }}" data-friend_name="{{ $chat['friend_name'] }}"  data-friend_nick="{{ $chat['friend_nick'] }}" data-friend_img="{{ $chat['friend_image'] }}"
data-user="{{ $chat['auth_id'] }}" data-auth_nick="{{ $chat['auth_nick'] }}" data-auth_img="{{ $chat['auth_image'] }}">  </i> 


@if( $chat['count'] > 0)
    <div class="number_messages"> 
       <span  data-friend="{{ $chat['friend_id'] }}">
          {{ $chat['count'] }} 
       </span>
    </div>
@endif


</div>



@else                  <!--  se ci si trova sul proprio profilo....   -->


<i class="fa-solid fa-envelope fa-2xl button_chat">  </i> 

@if($chat['count'] > 0)

    <div class="number_messages"> 
       <span>
          {{ $chat['count'] }} 
       </span>
    </div>
@endif




@endif







