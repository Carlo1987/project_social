 @foreach($images as $image)

 @if($image->user->type == 'public' || isFriend::check($image->user->id) || isset($user) && $user->id == Auth::user()->id )

 <div class="card w-100 rounded-4">

     <div class="user_index row my-2 ms-1">
   
             <div class="col-2">
                 <img src="{{ route('getAvatar', ['avatar' => $image->user->img]) }}" alt="user_image">
             </div>
             <div class="col-xl-10 col-lg-9 col-md-10 col-9">
                 <div class="row align-items-center" style="height: 60px;">
                     <div class="col-12">   
                        <a href="{{ route('users.show', ['user'=> $image->user->id]) }}" class="row w-100">
                            {{ $image->user->name  .' '. $image->user->surname }}
                        </a> 
                    </div>
                     <div class="col-12"> 
                     <a href="{{ route('users.show', ['user'=> $image->user->id]) }}" class="row w-100">
                            {{ '@'.$image->user->nick }}
                        </a> 
                     </div>
                 </div>
             </div>
        
     </div>

      <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="w-100"> 
         <img src="{{ route('images.show',  ['image' => $image->id]) }}" alt="image_user{{ Auth::user()->nick }}" class="w-100" style="height: 350px;">
      </a> 

     <div class="card-body">
         <p class="card-text fs-3 text-center"> {{ $image->description }} </p>
     </div>

     <div class="like_content">
         @include('like.like_images')
         @include('comment.total_comments_images')
     </div>

     <div class="mt-2">
         @include('comment.comments_images')
     </div>

 </div>

 @endif
 
 @endforeach


    
