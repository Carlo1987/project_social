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
              <h2 style="text-align: center;">{{ $user->name.' '.$user->surname }}</h2>
              <h3 style="text-align: center;">{{ '@'.$user->nick }}</h3>
            </div>
       </div>
    </div>



    <nav class="navbar navbar-expand-md navbarProfile d-flex flex-row  rounded-4 m-auto position-relative">

            <ul class="navbar-nav buttonProfile me-auto  d-flex flex-row justify-content-start">
               <div class="navbar-item" style="width:150px;">
                  @include('friendship.button_profile')
               </div>
            </ul>
    

            <button class="navbar-toggler bg-primary text-white me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarFiles" aria-controls="navbarFiles" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" style="font-size:15px; padding:10px; border:trasparent;" >    
               Mostra elementi 
            </button>

            <div class="collapse navbar-collapse" id="navbarFiles">

            <ul class="navbar-nav w-100 navbarProfileElements me-auto">
            <div class="nav-item">
                @if(count($images) != 0)
                    <a class="navbar-link" href="{{ route('image.detail', ['id' => $image_maxID->id ]) }}"> <i class="fa fa-picture-o" aria-hidden="true"></i>Foto({{ $images->count() }}) </a>
                @else
                    <a href="#" class="navbar-link"> <i class="fa fa-picture-o" aria-hidden="true"></i>  Foto(0) </a>
                @endif
            </div>
            <div class="nav-item">
                 @if(count($videos) != 0)
                    <a class="navbar-link" href="{{ route('video.detail', ['id' => $video_maxID->id]) }}"> <i class="fa fa-video-camera" aria-hidden="true"></i> Video({{ $videos->count() }})</a>
                 @else
                    <a href="#" class="navbar-link"> <i class="fa fa-video-camera" aria-hidden="true"></i> Video(0) </a>
                 @endif
            </div>
            <div class="nav-item">
                 @if($friendships->count() > 0 || $friend_requests->count() > 0)
                    <a class="navbar-link" href="{{ route('friendlists.show', ['friendlist'=> $user->id]) }}"> <i class="fa fa-user-circle-o" aria-hidden="true"></i> Amici({{ $friendlists->count() }}) </a>
                 @else
                    <a class="navbar-link" href="#">  <i class="fa fa-user-circle-o" aria-hidden="true"></i>  Amici(0) </a>
                 @endif
            </div>
            </ul>

            </div>     
    </nav>

     
   
        

           @if($user->id == Auth::user()->id || $user->type == 'public' || isFriend::check($user->id) )
 
           <div class="container container_normal d-flex justify-content-between">    <!--  inizio div grandezza grande -->
       
            <div class="content_images">
                   @include('includes.images-profile')
            </div>


            <div class="content_videos">
                @include('includes.videos-profile')
            </div>

        </div>     <!--  fine div grandezza grande -->



            <div class="container container_responsive w-100">                  <!-- inizio div responsive -->
                    <div class="nav_responsive fixed-top nav_{{ Themes::show(Auth::user()->id) }} z-1"> 
                        <div id="button_images_responsive" class="titles_{{ Themes::show(Auth::user()->id) }}">  Immagini   </div>
                        <div id="button_videos_responsive" class="titles_{{ Themes::show(Auth::user()->id) }}">  Video </div>
                    </div>
                  

                    <div class="content_images" id="images_responsive">
                          @include('includes.images-profile')
                    </div>


                    <div class="content_videos" id="videos_responsive">
                           @include('includes.videos-profile')
                    </div> 
            </div>                            <!--   fine div responsive  -->

          
            @else

           <div class="alert alert-light w-100 mt-3" role="alert">
                <h3>Questo Utente ha un profilo privato, richiedi la sua amicizia se vuoi vedere i suoi contenuti</h3>
           </div>

          @endif
     
    </div>
</div>
</div>


        <!-- contenuto chat -->

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasChat" aria-labelledby="offcanvasScrollingChat" style="width: 60%;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title w-100 text-center text-primary fs-3" id="offcanvasScrollingChat">   <i class="fa fa-facebook-square" aria-hidden="true"></i>   Chat con {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body offcanvasChat">
                 @include('chat.chat')
            </div>
        </div>

        <!-- fine chat -->

@endsection