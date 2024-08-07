@extends('layouts.app')

@section('content')

<?php $profile = true;   ?>

<div class="container">

   <div class="d-flex flex-column align-items-center gap-3">


      <div class="w-100 ps-2 d-flex justify-content-start"> 
       <div class="container_avatar">
          <div class="avatar">
             <img src="{{ route('getAvatar', ['avatar' => $user->img]) }}" class="img-fluid" alt="user_img">
          </div>

           <div class="user_datos">
              <h2>{{ $user->name.' '.$user->surname }}</h2>
              <h3 class="user_nick">{{ '@'.$user->nick }}</h3>
            </div>
       </div>
      </div> 


    @if( Auth::user()->id != $user->id && $user->id <= 19 && $user->id != 1 && Friendships::checkFriend_request( $friend_requests , $user->id) == false &&   Friendships::checkFriendship( $friendships , $user->id) == false  ) 
           <div class="alert alert-light p-1 mb-1 lang" role="alert" data-section="profile" data-article="fake_user" style="width: 98%; border-radius: 13px; color:black;"> 
              Questo è un utente fittizio, quindi la richiesta di amicizia verrà automaticamente accettata 
            </div> 
    @endif



         <nav class="navbar navbar-expand-lg navbarProfile d-flex flex-row  rounded-4 m-auto position-relative">

            <ul class="navbar-nav buttonProfile me-auto  d-flex flex-row justify-content-start">
               <div class="navbar-item" >
                  @include('friendship.button_profile')
               </div>
            </ul>
    


            <button class="navbar-toggler bg-primary text-white me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarFiles" aria-controls="navbarFiles" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" style="font-size:15px; padding:10px; border:trasparent;">    
                <i class="fa-solid fa-bars fa-xxl"></i>  <i class="fa fa-caret-down fa-sm" aria-hidden="true"></i>
            </button>

            <div class="collapse navbar-collapse mt-2"  id="navbarFiles">

            <ul class="navbar-nav w-100 navbarProfileElements me-auto">
            <div class="nav-item">
                @if(count($images) != 0)
                    <a class="navbar-link" href="{{ route('image.detail', ['id' => $image_maxID->id ]) }}"> <i class="fa fa-picture-o" aria-hidden="true"></i> <span class="lang" data-section="profile" data-article="pictures">Foto</span>({{ $images->count() }}) </a>
                @else
                    <a href="#" class="navbar-link"> <i class="fa fa-picture-o" aria-hidden="true"></i>  <span class="lang" data-section="profile" data-article="pictures">Foto</span>(0) </a>
                @endif
            </div>
            <div class="nav-item">
                 @if(count($videos) != 0)
                    <a class="navbar-link" href="{{ route('video.detail', ['id' => $video_maxID->id]) }}"> <i class="fa fa-video-camera" aria-hidden="true"></i><span class="lang" data-section="profile" data-article="videos">Video</span>({{ $videos->count() }})</a>
                 @else
                    <a href="#" class="navbar-link"> <i class="fa fa-video-camera" aria-hidden="true"></i> <span class="lang" data-section="profile" data-article="videos">Video</span>(0) </a>
                 @endif
            </div>
            <div class="nav-item">
                 @if($friendships->count() > 0 || $friend_requests->count() > 0)
                    <a class="navbar-link" href="{{ route('friendlists.show', ['friendlist'=> $user->id]) }}"> <i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="lang" data-section="profile" data-article="friends">Amici</span>({{ $friendlists->count() }}) </a>
                 @else
                    <a class="navbar-link" href="#">  <i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="lang" data-section="profile" data-article="friends">Amici</span>(0) </a>
                 @endif
            </div>
            </ul>

            </div>     
         </nav>

     
    
           @if($user->id == Auth::user()->id || $user->id != Auth::user()->id && $user->type == 'public' || isFriend::check($user->id) )
 
               @include('includes.container_files')

            @else

           <div class="alert alert-light w-100 mt-3" role="alert">
                <h3 class="lang" data-section="profile" data-article="private">Questo Utente ha un profilo privato, richiedi la sua amicizia se vuoi vedere i suoi contenuti</h3>
           </div>

          @endif
     
      </div>
   </div>
</div>



        @if(isFriend::check($user->id) )

        <!-- contenuto chat -->

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasChat" aria-labelledby="offcanvasScrollingChat">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title w-100 text-center text-primary fs-3" id="offcanvasScrollingChat">   <i class="fa fa-facebook-square" aria-hidden="true"></i>   Chat con {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body bodyChat">
                 @include('chat.chat')
            </div>
        </div>

        <!-- fine chat -->

        @endif

@endsection