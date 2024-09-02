@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show() }} lang" data-section="update" data-article="update_theme">{{ __('Cambia tema') }}</div>

                <div class="card-body {{ Themes::show() }}">
                    <form method="POST" action="{{ route('change.theme') }}" class="form_{{ Themes::show() }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end lang" data-section="update" data-article="profile">{{ __('Profilo') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select example" name="theme">
                                    <option value="default">Default</option>
                                    <option value="black" class="lang" data-section="update" data-article="black">Menù nero</option>
                                    <option value="opaque" class="lang" data-section="update" data-article="opaque">Stile opaco</option>
                                    <option value="blue" class="lang" data-section="update" data-article="blue">Stile azzurro</option>
                                </select>
                            </div>
                        </div>

                        <div class="w-100 text-center">
                                <button type="submit" class="btn lang edit_{{ Themes::show() }}" data-section="update" data-article="update_theme">
                                    {{ __('Cambia tema') }}
                                </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection