 
@foreach($images as $image)

 @if($image->user->type == 'public' || isFriend::check($image->user->id) || $user->id == Auth::user()->id )

 <div class="card card_files w-100 rounded-4">

     <div class="user_index ">

                 <img src="{{ route('getAvatar', ['avatar' => $image->user->img]) }}" alt="user_image">

                 <div class="container_index_user">
                        <a href="{{ route('users.show', ['user'=> $image->user->id]) }}">
                             <span class="user_nick">{{ $image->user->name  .' '. $image->user->surname .' - '}}</span> {{ '@'.$image->user->nick }}
                        </a>               
                 </div>

     </div>

      <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="file_index"> 
         <img src="{{ route('images.show',  ['image' => $image->id]) }}" alt="image_user{{ Auth::user()->nick }}">
      </a> 

     <div class="card-body mb-2 border-bottom border-dark">
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


    
