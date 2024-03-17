@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show(Auth::user()->id) }}">{{ __("Carica un'immagine") }}</div>

                <div class="card-body {{ Themes::show(Auth::user()->id) }}">
                    <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data" class="form_{{ Themes::show(Auth::user()->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="img" class="col-md-4 col-form-label text-md-end">{{ __("Scegli un'immagine") }}</label>

                            <div class="col-md-6">
                                <input id="img" type="file" class="form-control" name="img">
                            </div>
                        </div>

                        <div class="input-group">
                            <span class="input-group-text comment_{{ Themes::show(Auth::user()->id) }}">Descrivi la tua immagine</span>
                            <textarea class="form-control" aria-label="With textarea" name="description"></textarea>
                        </div>

                        <div class="w-100 text-center mt-3">
                                <button type="submit" class="btn">
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