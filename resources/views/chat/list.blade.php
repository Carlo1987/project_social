@extends('layouts.app')

@section('content')



<div class="w-100 d-flex flex-row justify-content-center mb-1">
  <div class="container_titles">
     <h4 class="title_general lang" data-section="chat" data-article="messages"> Messaggi </h4>
  </div>
</div>


<div class="container">

@if(count($chats) > 0)       <!--  se ci sono messaggi .... -->

    <div class="content_search">

       @foreach($chats as $chat)

 
        <div class="content_search_row px-1">   
                <a href="{{ route('users.show', ['user'=> $chat['friend_id'] ]) }}">
                    <div>
                        <img src="{{ route('getAvatar', ['avatar' => $chat['friend_image'] ]) }}" alt="user_img">
                    </div>

                    <div> {{ $chat['friend_name'] }} </div>
                    <div> {{ $chat['friend_surname'] }} </div>
                </a>

                <div class="container_button_chat p-2 rounded">
                    @include('includes.button_chat')    <!--  bottone della chat   -->
                </div>
                
             

                @include('includes.chat_body')                <!--  corpo della chat   -->
              
        </div>
  
        @endforeach


    </div>

    
@else <!--  se non ci sono ancora messaggi ....  -->

<div class="alert {{ Themes::show() }} lang" data-section="chat" data-article="no_messages">
    Nessun messaggio
</div>

@endif


</div>

@endsection





