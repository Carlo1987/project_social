@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show(Auth::user()->id) }}">{{ __('Modifica commento') }}</div>

                <div class="card-body {{ Themes::show(Auth::user()->id) }}">
                    <form method="POST" action="{{ route('comments.update', ['comment' => $comment->id]) }}" class="form_{{ Themes::show(Auth::user()->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3 align-items-center">
                            <label for="comment" class="col-lg-2">Modifica:</label>

                            <div class="col-lg-10">
                                <input id="comment" type="text" class="form-control" name="comment" value="{{ $comment->comment }}">
                            </div>
                        </div>

                        <input type="hidden" name="url" value="<?=url()->previous()?>">

                            <div class="w-100 text-center">
                                <button type="submit" class="btn w-35">
                                    {{ __('Aggiorna commento') }}
                                </button>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection