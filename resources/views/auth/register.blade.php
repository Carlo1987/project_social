@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header lang"  style=" background-color: #0d6efd; color:white;" data-section="register" data-article="title"> 
                     registrati
                 </div>

                <div class="card-body">

                        <div class="text-center bg-primary text-light rounded p-1  mb-2">
                           <span class="fs-5 me-2 lang" data-section="register" data-article="fake_users"> Oppure usa un utente fittizzio </span> 
                            <i class="fa-solid fa-users fa-lg download_fakeUsers" style="cursor: pointer;"> </i>
                        </div>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                     
                   

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end lang" data-section="register" data-article="name">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="surname" class="col-md-4 col-form-label text-md-end lang" data-section="register" data-article="surname">{{ __('Cognome') }}</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" autocomplete="surname" autofocus>

                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gender" class="col-md-4 col-form-label text-md-end lang" data-section="register" data-article="gender">{{ __('Genere') }}</label>

                            <div class="col-md-5" style="align-self: center;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="male">
                                    <label class="form-check-label lang" for="gender" data-section="register" data-article="male">Uomo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="female">
                                    <label class="form-check-label lang" for="gender" data-section="register" data-article="female">Donna</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nick" class="col-md-4 col-form-label text-md-end">{{ __('Nickname') }}</label>

                            <div class="col-md-6">
                                <input id="nick" type="text" class="form-control @error('nick') is-invalid @enderror" name="nick" value="{{ old('nick') }}" autocomplete="nick" autofocus>

                                @error('nick')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end lang"  data-section="login" data-article="email">{{ __('Indirizzo email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror lang_placeholder" name="email" value="{{ old('email') }}" autocomplete="email" data-section="register" data-article="placeholder" placeholder="Inserisci la tua VERA email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end lang" data-section="register" data-article="confirm">{{ __('Conferma Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end lang" data-section="register" data-article="profile">{{ __('Profilo') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select example" id="type" name="type">
                                    <option value="public" class="lang" data-section="register" data-article="public">Pubblico</option>
                                    <option value="private" class="lang" data-section="register" data-article="private">Privato</option>
                                </select>
                            </div>
                        </div>

              <!--           <div class="row mb-3">
                            <label for="img" class="col-md-4 col-form-label text-md-end">{{ __("Scegli un'immagine") }}</label>

                            <div class="col-md-6">
                                <input id="img" type="file" class="form-control @error('img') is-invalid @enderror" name="img">

                                @error('img')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>  -->

             
                            <div class="w-100 text-center">
                                <button type="submit" class="btn btn-primary fs-5 lang" style="width: auto;" data-section="register" data-article="save">
                                    {{ __('Salva') }}
                                </button>
                            </div>
               
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection