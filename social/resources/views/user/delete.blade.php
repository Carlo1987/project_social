@extends('layouts.app')

@section('content')

<div class="card {{ Themes::show(Auth::user()->id) }}" style="width: 28rem; margin: 0 auto; text-align: center; padding-bottom:10px;">
    <div class="card-body">
        <h5 class="card-title text-danger display-6">Attenzione!! </h5>
        <p class="card-text" style="font-size: 16px;"><U>Se cancelli il tuo Acount, perderai tutti i tuoi dati.</U> <br>
            Sei sicuro di voler continuare?
        </p>
    </div>

    <div class="confirm_choise">
        <form method="GET" action="{{ route('deleteAcount', ['id'=>$user->id]) }}">
            <div> <input type="submit" name="rejection" class="btn btn-secondary" value="Ho cambiato idea"> </div>
            <div> <input type="submit" name="accept" class="btn btn-primary" value="Si, sono sicuro"> </div>
        </form>
    </div>
</div>
</div>

@endsection