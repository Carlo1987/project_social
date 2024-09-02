@if($user->id == Auth::user()->id)
<div class="btn-group dropdown mt-0">
    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
       <span class="lang" data-section="profile" data-article="friendship_time">Amici da </span> {{ \FormatTime::time($friend->created_at) }}
    </button>

  

    <div class="dropdown-menu pt-0 w-100 btn btn-danger pb-0 rounded">
        <a href="{{ route('friendlist.delete', ['friendlist'=>$friend->id]) }}" class=" text-light fs-5 lang"  data-section="profile" data-article="delete_friend">
            Elimina amicizia
        </a>
    </div>
</div>




@endif

