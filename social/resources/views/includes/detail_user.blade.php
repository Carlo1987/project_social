
    <div class="user_index mb-2">             
        @if(isset($type) && $type == 'image')

        <div class="w-100 d-flex flex-row align-items-center justify-content-start gap-3">
            <div>
                 <img src="{{ route('getAvatar', ['avatar' => $image->user->img]) }}" alt="user_image">
             </div>
             <div>
                 <div class="row align-items-center" >
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

        @else

        <div class="w-100 d-flex flex-row align-items-center justify-content-start gap-3">
            <div>
                 <img src="{{ route('getAvatar', ['avatar' => $video->user->img]) }}" alt="user_video">
             </div>
             <div>
                 <div class="row align-items-center" >
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
            
        @endif
  

       <div class="d-flex align-items-center position-relative" style="width: 10%;">

        @if(isset($image) && $image->user->id == Auth::user()->id || isset($video) && $video->user->id == Auth::user()->id)

        <i class="fa fa-bars fa-3x menu_delete_elements" aria-hidden="true"  style="cursor:pointer;"> 
        <ul class="top-0 start-50">
                 <li>  <a href="{{ url()->previous() }}"> Torna indietro </a> </li>

                 @if(isset($image))
                 <li class="destroy_image" data-id="{{ $image->id }}" style="cursor:pointer;"> Elimana file </li>
                 @elseif(isset($video))
                 <li class="destroy_video" data-id="{{ $video->id }}" style="cursor:pointer;"> Elimana file </li>
                 @endif
        </ul>
        </i>      

        @else

        <a href="{{ url()->previous() }}">
           <i class="fa fa-times fa-2x" aria-hidden="true">   </i>
        </a>
        @endif

       </div>

    </div>

