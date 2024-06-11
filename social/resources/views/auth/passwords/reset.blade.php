@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-light">{{ __('Resetta password') }}</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end lang" data-section="forget_password" data-article="email">{{ __('Indirizzo email:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password:') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end lang" data-section="forget_password" data-article="confirm_password">{{ __('Conferma:') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                            <div class="w-100 text-center">
                                <button type="submit" class="btn btn-primary lang" data-section="forget_password" data-article="reset">
                                    {{ __('Resetta Password') }}
                                </button>
                            </div>
                     
                    </form>
                </div>
            </div>

        @if(session('error_reset'))
          <div class="alert alert-danger" role="alert">
             {{ session('error_reset') }}
          </div>
        @endif

        @if(session('success_reset'))
          <div class="alert alert-success" role="alert">
             {{ session('success_reset') }}
          </div>
        @endif




        </div>
    </div>
</div>
@endsection
