@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-light lang" data-section="forget_password" data-article="confirm_button">{{ __('Conferma password') }}</div>

                <div class="card-body lang" data-section="forget_password" data-article="confirm">
                    {{ __('Per favore, conferma la password prima di continuare') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary lang" data-section="forget_password" data-article="confirm_button">
                                    {{ __('Conferma Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link lang" href="{{ route('password.request') }}" data-section="forget_password" data-article="forget">
                                        {{ __('Password dimenticata?') }}
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
