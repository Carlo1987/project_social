@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show(Auth::user()->id) }}">{{ __('Cambia password') }}</div>

                <div class="card-body {{ Themes::show(Auth::user()->id) }}">
                    <form method="POST" action="{{ route('change.theme') }}" class="form_{{ Themes::show(Auth::user()->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('Profilo') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select example" name="theme">
                                    <option value="default">Default</option>
                                    <option value="black">Menù nero</option>
                                    <option value="opaque">Stile opaco</option>
                                    <option value="green">Stile verde</option>
                                    <option value="red">Stile rosso</option>
                                    <option value="blue">Stile azzurro</option>
                                </select>
                            </div>
                        </div>

                        <div class="w-100 text-center">
                                <button type="submit" class="btn">
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