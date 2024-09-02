@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show() }} lang" data-section="update" data-article="update_datas">{{ __('Aggiorna dati') }}</div>

                <div class="card-body {{ Themes::show() }}">
                    <form method="POST" action="{{ route('users.update', ['user'=>Auth::user()]) }}" enctype="multipart/form-data" class="form_{{ Themes::show() }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end lang"  data-section="register" data-article="name">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" autocomplete="name" autofocus>

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
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ Auth::user()->surname }}" autocomplete="surname" autofocus>

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
                                @if(Auth::user()->gender == 'male')
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="male" checked="checked">
                                    <label class="form-check-label lang" for="gender"  data-section="register" data-article="male">Uomo</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="female">
                                    <label class="form-check-label lang" for="gender" data-section="register" data-article="female">Donna</label>
                                </div>
                                @elseif(Auth::user()->gender == 'female')
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="male">
                                    <label class="form-check-label lang" for="gender" data-section="register" data-article="male">Uomo</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="female" checked="checked"> 
                                    <label class="form-check-label lang" for="gender" data-section="register" data-article="female">Donna</label>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nick" class="col-md-4 col-form-label text-md-end">{{ __('Nickname') }}</label>

                            <div class="col-md-6">
                                <input id="nick" type="text" class="form-control @error('nick') is-invalid @enderror" name="nick" value="{{ Auth::user()->nick }}" autocomplete="nick" autofocus>

                                @error('nick')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end lang" data-section="login" data-article="email">{{ __('Indirizzo email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end lang" data-section="register" data-article="profile">{{ __('Profilo') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select type" id="type" name="type">
                                  @if(Auth::user()->type == 'public')
                                    <option value="public" class="lang" data-section="register" data-article="public" selected>Pubblico</option>
                                    <option value="private" class="lang" data-section="register" data-article="private">Privato</option>
                                  @elseif(Auth::user()->type == 'private')
                                    <option value="public" class="lang" data-section="register" data-article="public">Pubblico</option>
                                    <option value="private" class="lang" data-section="register" data-article="private" selected>Privato</option>                 
                                  @endif
                                </select>
                            </div>
                        </div>

                        <div class="w-100 text-center">
                                <button type="submit" class="btn edit_{{ Themes::show() }} lang"  data-section="update" data-article="button_datas">
                                    {{ __('Aggiorna') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection