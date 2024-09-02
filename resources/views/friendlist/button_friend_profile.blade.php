@foreach($friendlists as $friendlist)
@if($friendlist->user_id == Auth::user()->id && $friendlist->friend_id == $user->id || $friendlist->friend_id == Auth::user()->id && $friendlist->user_id == $user->id)
<div class="btn-group dropdown w-100 position-relative">
    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="lang" data-section="profile" data-article="friendship_time">Amici </span> <!-- {{ FormatTime::time($friendlist->created_at) }} -->
    </button>
    <ul class="dropdown-menu  w-auto position-absolute pt-0 fs-5 z-2 rounded" style="background-color: white; ">

        <a href="{{route('friendlist.delete', ['friendlist'=>$friendlist->id,'profile'])  }}" class="dropdown-item link-danger w-100 lang" data-section="profile" data-article="delete_friend">
            Elimina amicizia
        </a>
    </ul>
</div>
@endif
@endforeach