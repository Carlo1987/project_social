@extends('layouts.app')

@section('content')

<div class="card {{ Themes::show() }}" style="width: 28rem; margin: 0 auto; text-align: center; padding-bottom:10px;">
    <div class="card-body">
        <h5 class="card-title text-danger display-6 lang" data-section="delete_user" data-article="warning">Attenzione!! </h5>
        <p class="card-text" style="font-size: 16px;"><U class="lang" data-section="delete_user" data-article="message">Se cancelli il tuo Acount, perderai tutti i tuoi dati.</U> <br>
           <span class="lang" data-section="delete_user" data-article="sure"> Sei sicuro di voler continuare? </span>
        </p>
    </div>

    <div class="confirm_choise">
        <form method="POST" action="{{ route('deleteAcount', ['id'=>$user->id]) }}">
        @csrf   
            <div> <button type="submit" name="accept" class="btn btn-primary lang" data-section="delete_user" data-article="accept"> Ho cambiato idea </button> </div>
        </form>
    </div>
</div>
</div>

@endsection