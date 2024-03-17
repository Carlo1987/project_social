@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show(Auth::user()->id) }}">{{ __("Scegli un'immagine per il tuo profilo") }}</div>

                <div class="card-body {{ Themes::show(Auth::user()->id) }}">
                    <form method="POST" action="{{ route('updateAvatar') }}" enctype="multipart/form-data"  class="form_{{ Themes::show(Auth::user()->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="img" class="col-md-4 col-form-label text-md-end">{{ __("Scegli un'immagine") }}</label>

                            <div class="col-md-6">
                                <input id="img" type="file" class="form-control"  name="img">
                            </div>
                        </div>

                        <div class="w-100 text-center">
                                <button type="submit" class="btn w-50">
                                    {{ __('Carica immagine') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection