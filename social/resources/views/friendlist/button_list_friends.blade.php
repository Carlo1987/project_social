@if($user->id == Auth::user()->id)
<div class="btn-group dropend mt-0">
    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Amici da {{ \FormatTime::time($friend->created_at) }}
    </button>
    <ul class="dropdown-menu pt-0" style="background-color: transparent; border:transparent;">
        <a href="{{ route('friendlist.delete', ['friendlist'=>$friend->id]) }}" class="btn btn-danger text-light" style="font-size: 15px;">Elimina amicizia</a>
    </ul>
</div>
@endif