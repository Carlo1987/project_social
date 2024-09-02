@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show() }} lang" data-section="update" data-article="update_password">{{ __('Cambia password') }}</div>

                <div class="card-body {{ Themes::show() }}">
                    <form method="POST" action="{{ route('updatePassword') }}" enctype="multipart/form-data" class="form_{{ Themes::show() }}">
                        @csrf

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="row mb-3">
                            <label for="oldPassword" class="col-md-4 col-form-label text-md-end lang" data-section="update" data-article="old_password">{{ __('Vecchia password') }}</label>

                            <div class="col-md-6">
                                <input id="oldPassword" type="password" class="form-control @error('oldPassword') is-invalid @enderror" name="old_Password" required autocomplete="old-password">

                                @error('oldPassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end lang" data-section="update" data-article="new_password">{{ __('Nuova password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end lang" data-section="update" data-article="confirm_password">{{ __('Conferma ') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        @if(session('error_password'))
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4"> 
                                <span class="text-danger">
                                    <strong>{{ session('error_password') }}</strong>
                                </span>
                            </div>
                        </div>
                        @endif

                        <div class="w-100 text-center">
                                <button type="submit" class="btn edit_{{ Themes::show() }} lang" data-section="update" data-article="button_password">
                                    {{ __('Aggiorna password') }}
                                </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection