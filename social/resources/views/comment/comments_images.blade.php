

@if(count($image->comments) != 0)
    @if(isset($detail) && $detail)
    <?php $comments = $image->comments ?>
    @else
    <?php $comments = $image->comments_limit ?>
    @endif

<ul class="list-group list-group-flush comments">
        @foreach($comments as $comment)
         <li class="list-group-item ">
            <div class="row">

            <a href="{{ route('users.show', ['user'=> $comment->user->id]) }}" class="col-10">
                       <img src="{{ route('getAvatar', ['avatar' => $comment->user->img]) }}" style="width: 45px; height:42px; border-radius:500px;">
                       <div class="ms-2">  {{ $comment->comment }} </div>
            </a>
   
         
            @if($comment->user_id == Auth::user()->id && $comment->image_id == $image->id)
            <div class="col-2 mt-2 position-relative button_comments">
              <div class="btn-group dropend">
                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                   <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu">
                    <li> <a href="{{ route('comments.edit', ['comment' => $comment->id]) }}">Modifica</a></li>
                    <li> <a href="{{ route('comment.delete', ['id' => $comment->id]) }}">Cancella</a></li>
                </ul>
               </div>
            </div>
            @endif
            </div>
 
         </li>
        @endforeach
 </ul>

@else

     <div class="alert alert-secondary w-75 m-auto text-center fs-4">Nessun commento</div>

@endif


<form action="{{ route('comments.store') }}" method="POST" class="my-2 ps-1 form_comments">
        @csrf

        <div class="row align-items-center">
            <div class="col-10 d-flex flex-row align-items-center">
                <img src="{{ route('getAvatar', ['avatar' => Auth::user()->img]) }}" alt="user_img" style="width: 45px; height:42px; border-radius:500px;">
                <input type="text" name="comment" placeholder="scrivi un commento..." class="w-100 rounded-5 ms-1 ps-3 py-1 border border-0 fs-5">
            </div>

            <input type="hidden" name="file_id" value="{{ $image->id }}">
            <input type="hidden" name="type" value="image">

            <div class="col-2 ps-0">
               <button type="submit"> <img src="{{ asset('img/arrow.png') }}" class="arrow"> </button>
            </div>
        </div>   
</form>
