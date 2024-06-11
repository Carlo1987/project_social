@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header bg-primary text-light lang" data-section="forget_password" data-article="reset">{{ __('Resetta password') }}</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end lang" data-section="forget_password" data-article="email">{{ __('Indirizzo email:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                           
                            </div>
                        </div>

                        <div class="w-100 text-center">
                                <button type="submit" class="btn btn-primary lang" data-section="forget_password" data-article="link_reset">
                                    {{ __('Invia un link per resettare la password') }}
                                </button>
                        </div>

                    </form>
                </div>
            </div>

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error_user'))
                         <div class="alert alert-danger" role="alert">
                            {{ session('error_user') }}
                         </div>
                    @endif


        </div>
    </div>
</div>
@endsection
