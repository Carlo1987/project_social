<!-- <div class="container "> -->

    <ul class="container_chat">
      @if($chats->count() > 0)

        @foreach($chats as $chat)
           @if($chat->user1 == Auth::user()->id && $chat->user2 == $user->id )
           <li class="d-flex flex-column p-2 message_user"> 
           <div class="ms-1 w-100  d-flex flex-row justify-content-between">
                <div style="width: 80%;">
                   <img src="{{  route('getAvatar', ['avatar' => Auth::user()->img]) }}">
                   {{ Auth::user()->nick }}
                </div>
                <div style="width: 10%;">
                   {{ $chat->hour }}
                </div>
               
              </div>
              <div style="width: 100%; border-top:1px solid black; margin-top:3px;">
                <div style="width: 90%; margin:0 auto;">
                   {{ $chat->text }}
                </div>
              </div>
           </li>
           @elseif($chat->user1 == $user->id && $chat->user2 == Auth::user()->id)
           <li class="d-flex flex-column p-2 message_friend"> 
              <div class="ms-1 w-100  d-flex flex-row justify-content-between">
                <div style="width: 80%;">
                   <img src="{{  route('getAvatar', ['avatar' => $user->img]) }}">
                   {{ $user->nick }}
                </div>
                <div style="width: 10%;">
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

      @else
       <div class="alert alert-success text-center fs-5" role="alert"> Ora tu e {{ $user->name }} siete amici! </div>
       @endif

    </ul>

    <form  class="my-3 form_chat" id="form_chat">
        <input type="hidden" class="friend_data" data-friend_id="{{ $user->id }}" data-friend_nick="{{ $user->nick }}" data-friend_img="{{ $user->img }}">
        <div class="row">
            <div class="col-md-10">
                <input class="auth_data w-100" type="text" data-auth_id="{{ Auth::user()->id }}" data-auth_nick="{{ Auth::user()->nick }}" data-auth_img="{{ Auth::user()->img }}"/>
            </div>
            <div class="col-md-2">
                  <button type="submit" class="btn btn-primary mb-2 px-4 fs-5">Invia</button>
            </div>
        </div>
    </form>

   

<!-- </div> -->



<script>
    let socket = io.connect('http://localhost:3000');

    socket.on('connection');

    const messages = document.querySelector('.container_chat');
    const form = document.querySelector('.form_chat');
    const input_message = document.querySelector('.auth_data');
    const input_hidden =  document.querySelector('.friend_data');

    let newDate = new Date();

    let auth_id = input_message.getAttribute('data-auth_id');
    let friend_id = input_hidden.getAttribute('data-friend_id');
 
/* 

    socket.emit('getMessages', {
      user1: auth_id,
      user2: friend_id
    }); 

    showMessages('getMessages'); */


    form.addEventListener('submit', (e) => {
      e.preventDefault();

      let current_day = `${newDate.getDay()}/${newDate.getMonth()+1}/${newDate.getFullYear()}`;


      if (input_message.value != '') {

        let data = {
          user1: auth_id,
          user2: friend_id,
          text: input_message.value,
          day: current_day,
          hour: `${setNumberCalendary(newDate.getHours())}:${setNumberCalendary(newDate.getMinutes())}`
        };
 
        socket.emit("chat", data);
       

      }
    });


    showMessages('chat');

   location.href = "#form_chat";



    function showMessages(url) {
      socket.on(url, (data) => {
    
          if (auth_id == data.user1 && friend_id == data.user2 || auth_id == data.user2 && friend_id == data.user1) {
  
            let current_day = `${newDate.getDay()}/${newDate.getMonth()+1}/${newDate.getFullYear()}`;
            const url_complete = `https://${document.location.hostname}/progetti/progetto_social/social/public/index.php/`;

            let li = `
            <li class="d-flex flex-column p-2 message_user"> 
              <div class="ms-1 w-100  d-flex flex-row justify-content-between">
                <div style="width: 80%;">
                   <img src="${url_complete}user/getAvatar/${input_message.getAttribute('data-auth_img')}">
                   ${input_message.getAttribute('data-auth_nick')}
                </div>
                <div style="width: 10%;">
                ${data.hour}
                </div> 
              </div>
              <div style="width: 100%; border-top:1px solid black; margin-top:3px;">
                <div style="width: 90%; margin:0 auto;">
                ${data.text}
                </div>
              </div>
           </li>
            `;


            if (data.user1 != auth_id){
              
             li = `
            <li class="d-flex flex-column p-2 message_friend"> 
              <div class="ms-1 w-100  d-flex flex-row justify-content-between">
                <div style="width: 80%;">
                   <img src="${url_complete}user/getAvatar/${input_hidden.getAttribute('data-friend_img')}">
                   ${input_hidden.getAttribute('data-friend_nick')}
                </div>
                <div style="width: 10%;">
                ${data.hour}
                </div>
              </div>
              <div style="width: 100%; border-top:1px solid black; margin-top:3px;">
                <div style="width: 90%; margin:0 auto;">
                ${data.text}
                </div>
              </div>
           </li>
            `;

            }          

           messages.insertAdjacentHTML('beforeend',li);
           location.href = "#form_chat";
          }
        })


    }



    function setNumberCalendary(number){
       let result = number;
       if(number < 10)   result = `0${number}`;
       return result;
    }




  </script>