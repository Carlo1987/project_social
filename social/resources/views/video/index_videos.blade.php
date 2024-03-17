

@foreach($videos as $video)

 @if( $video->user->type == 'public' ||  isFriend::check($video->user->id) || isset($user) &&  $user->id == Auth::user()->id )

 <div class="card w-100 rounded-4">

     <div class="user_index row my-2 ms-1">
   
             <div class="col-2 ">
                 <img src="{{ route('getAvatar', ['avatar' => $video->user->img]) }}" alt="user_video">
             </div>
             <div class="col-xl-10 col-lg-9 col-md-10 col-9">
                 <div class="row align-items-center" style="height: 60px;">
                     <div class="col-12">   
                        <a href="{{ route('users.show', ['user'=> $video->user->id]) }}" class="row w-100">
                            {{ $video->user->name  .' '. $video->user->surname }}
                        </a> 
                    </div>
                     <div class="col-12"> 
                        <a href="{{ route('users.show', ['user'=> $video->user->id]) }}" class="row w-100">
                            {{ '@'.$video->user->nick }}
                        </a> 
                     </div>
                 </div>
             </div>
        
     </div>

      <a href="{{ route('video.detail', ['id' => $video->id]) }}"> 
         <video class="video" style="width:100%; height: 350px;" controls>
            <source src="{{ route('videos.show', ['video'=> $video->id]) }}">
         </video>
      </a> 

     <div class="card-body">
         <p class="card-text fs-3 text-center"> {{ $video->description }} </p>
     </div>

     <div class="like_content">
         @include('like.like_videos')
         @include('comment.total_comments_videos')
     </div>

     <div class="mt-2">
         @include('comment.comments_videos')
     </div>

 </div>

 @endif
 
 @endforeach


    
