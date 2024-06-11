@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header lang"  style=" background-color: #0d6efd; color:white;" data-section="forget_password" data-article="verify_code">{{ __('Verifica codice') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success lang" role="alert" data-section="forget_password" data-article="warning">
                            {{ __("E' stato inviato un link di verifica al tuo indirizzo email") }}
                        </div>
                    @endif

                    <div><h2>Inserisci il codice che hai ricevuto per email</h2></div>

                   <span class="lang" data-section="forget_password" data-article="verify_email"> {{ __('Prima di procedere, controlla il link di verifica nella tua email') }}</span>
                    <span class="lang" data-section="forget_password" data-article="link_email">{{ __('Se non hai ricevuto il link') }}</span>,
                   
                    <form class="d-inline" method="POST" action="{{ route('code.verify') }}">
                        @csrf

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror lang_placeholder" name="code" placeholder="Inserisci codice" data-section="forget_password" data-article="code_placeholder">

                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="token" value="{{ $token }}">

                          <div class="row mb-0">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary w-25 lang" data-section="forget_password" data-article="verify_button">
                                    {{ __('Verifica') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
