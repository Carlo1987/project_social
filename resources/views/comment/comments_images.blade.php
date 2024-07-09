

@if(count($image->comments) != 0)
    @if(isset($detail) && $detail)
    <?php $comments = $image->comments ?>
    @else
    <?php $comments = $image->comments_limit ?>
    @endif

<ul class="list-group list-group-flush comments">
        @foreach($comments as $comment)
         <li class="list-group-item ">

            <div class="w-100 d-flex flex-row justify-content-between">

                <a href="{{ route('users.show', ['user'=> $comment->user->id]) }}" style="display: block;">
                    <img src="{{ route('getAvatar', ['avatar' => $comment->user->img]) }}" style="width: 35px; height:32px; border-radius:500px;">
                    <span class="nick_comment"> {{ '@'.$comment->user->nick }} </span>
                </a>

                @if($comment->user_id == Auth::user()->id && $comment->image_id == $image->id)
                <div class="col-2 mt-2 position-relative button_comments">
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bars fa-lg" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li> <a href="{{ route('comments.edit', ['comment' => $comment->id]) }}" class="lang" data-section="files" data-article="update">Modifica</a></li>
                            <li> <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="lang" data-section="files" data-article="delete">Cancella</a></li>
                        </ul>
                    </div>
                </div>
                @endif


           
            </div>
 
            <div class="w-100  border-top border-dark">
                  {{ $comment->comment }}
            </div>

         </li>
        @endforeach
 </ul>

@else

     <div class="alert alert-secondary w-75 m-auto text-center fs-4 lang" data-section="files" data-article="no_comment">Nessun commento</div>

@endif


<form action="{{ route('comments.store') }}" method="POST" class="my-2 ps-1 form_comments">
        @csrf

        <input type="text" name="comment" placeholder="scrivi un commento...." class="rounded-5 ms-1 ps-3 py-1 border border-0 fs-5 lang_placeholder" data-section="files" data-article="write_comment">
        

        <input type="hidden" name="file_id" value="{{ $image->id }}">
        <input type="hidden" name="type" value="image">


        <button type="submit" class="rounded me-2"> <img src="{{ asset('img/arrow.png') }}" class="arrow"> </button>
    
</form>
