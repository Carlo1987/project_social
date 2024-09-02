@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @if (session('resent'))
                    <div class="alert alert-success my-3 lang" role="alert"  data-section="verify" data-article="session">
                        E' stato inviato un link di verifica al tuo indirizzo email
                    </div>
                    @endif

            <div class="card">
                <div class="card-header lang" style=" background-color: #0d6efd; color:white;" data-section="verify" data-article="title"> Verifica il tuo indirizzo email </div>

                <div class="card-body">
                

                    <p class="fs-5 text-center lang" data-section="verify" data-article="message"> Prima di procedere, controlla il link di verifica nella tua e-mail. </p>
             
                      
                        <form class="w-100" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                     
                        <button type="submit" class="btn btn-link w-100 text-center fs-5 lang" data-section="verify" data-article="link"> Se non hai ricevuto il link clicca qui per riceverne un altro </button>.
                    </form>
                 
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection