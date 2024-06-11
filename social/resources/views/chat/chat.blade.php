

    <ul class="container_chat">
      @if($chats->count() > 0)

      @foreach($days_chat as $day)

        <div class="day_chat"> {{ FormatTime::setDay($day->day) }}  </div> 
    

        @foreach($chats  as $chat)
           @if($chat->user1 == Auth::user()->id && $chat->user2 == $user->id && $chat->day == $day->day)
           <?php $id = $chat->id ?>
           <li class="d-flex flex-column p-2 message message_user"> 
           <div class="ms-1 w-100  d-flex flex-row justify-content-between align-items-center">
                <div class="user_chat">
                   <img src="{{  route('getAvatar', ['avatar' => Auth::user()->img]) }}">
                   {{ Auth::user()->nick }}
                </div>
                <div class="d-flex flex-row justify-content-evenly  hour_chat">
                   {{ $chat->hour }}
                   <i class="fa-regular fa-trash-can delete_chat" data-id="{{ $chat->id }}" onclick="deleteChats(<?=$id?>)"></i>
                </div>
               
              </div>
              <div style="width: 100%; border-top:1px solid black; margin-top:3px;">
                <div style="width: 90%; margin:0 auto;">
                   {{ $chat->text }}
                </div>
              </div>
           </li>
           @elseif($chat->user1 == $user->id && $chat->user2 == Auth::user()->id && $chat->day == $day->day)
           <li class="d-flex flex-column p-2 message message_friend"> 
              <div class="ms-1 w-100  d-flex flex-row justify-content-between align-items-center">
                <div class="user_chat">
                   <img src="{{  route('getAvatar', ['avatar' => $user->img]) }}">
                   {{ $user->nick }}
                </div>
                <div class="hour_chat">
                   {{ $chat->hour }}
                </div>
               
              </div>
              <div style="width: 100%; border-top:1px solid black; margin-top:3px;">
                <div style="width: 90%; margin:0 auto;">
                   {{ $chat->text }}
                </div>
              </div>
           </li>
           @endif
        @endforeach


        @endforeach

      @else
       <div class="alert alert-success text-center fs-5" role="alert"> 
         <span class="lang" data-section ="chat" data-article="friend"> Hai stretto amicizia con </span> {{ $user->name }} 
      </div>
       @endif

    </ul>

    <form  class="my-3 form_chat" id="form_chat">
        <input type="hidden" class="friend_data" data-friend_id="{{ $user->id }}" data-friend_nick="{{ $user->nick }}" data-friend_img="{{ $user->img }}">
        <div class="row">
            <div class="col-sm-10 col-9">
                <input class="auth_data w-100" type="text" data-auth_id="{{ Auth::user()->id }}" data-auth_nick="{{ Auth::user()->nick }}" data-auth_img="{{ Auth::user()->img }}"/>
            </div>
            <div class="col-sm-2 col-3">
                  <button type="submit" class="btn btn-primary mb-2 px-4 fs-5 lang" data-section ="chat" data-article="send">Invia</button>
            </div>
        </div>
    </form>



@include('chat.JS')



   