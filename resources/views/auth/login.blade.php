@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style=" background-color: #0d6efd; color:white;">{{ __('Login') }}</div>

                <div class="card-body">

                        <div class="text-center bg-primary text-light rounded p-1  mb-2">
                           <span class="fs-5 me-2 lang" data-section="register" data-article="fake_users"> Oppure usa un utente fittizzio </span> 
                            <i class="fa-solid fa-users fa-lg download_fakeUsers" style="cursor: pointer;"> </i>
                        </div>

                    <form method="POST" action="{{ route('login') }}" class="lang_form">
                        @csrf

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end lang" data-section="login" data-article="email"> {{ __('Indirizzo email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            @if(session('error_login'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ session('error_login') }}</strong>
                                </span>
                                @endif
                        </div>

                        <div class="row">
                            <div class="col-lg-8 offset-lg-3 col-11 offset-1">
                                <button type="submit" class="btn btn-primary fs-5" style="width: 80px;">
                                    {{ __('Login') }}
                                </button>
           
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link fs-5 text-black lang" href="{{ route('password.request') }}"  data-section="login" data-article="forget_password">
                                        {{ __('Password dimenticata? clicca qui') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
