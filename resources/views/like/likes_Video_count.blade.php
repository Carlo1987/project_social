<div class="likes_count">
    (<span class="count">{{ count($video->likes) }}</span>)

    @if(count($video->likes) != 0)
    <ul>
 
       @foreach($video->likes as $like)
       <li class="likes_users" data-videoID="{{ $video->id }}">
           <div>
               <img src="{{ route('getAvatar', ['avatar' => $like->user->img]) }}">
           </div>
           <div>
               <a href="{{ route('users.show', ['user'=> $like->user_id]) }}">
                   <span> {{ '@'.$like->user->nick }} </span>
               </a>
           </div>
       </li>
       @endforeach
   </ul>
   @endif
 
</div>