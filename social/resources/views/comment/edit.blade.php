@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show() }} lang" data-section="files" data-article="title_comment">{{ __('Modifica commento') }}</div>

                <div class="card-body {{ Themes::show() }}">
                    <form method="POST" action="{{ route('comments.update', ['comment' => $comment->id]) }}" class="form_{{ Themes::show() }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3 align-items-center">
                            <label for="comment" class="col-lg-2"><span class="lang" data-section="files" data-article="update">Modifica</span>:</label>

                            <div class="col-lg-10">
                                <input id="comment" type="text" class="form-control" name="comment" value="{{ $comment->comment }}">
                            </div>
                        </div>

                        <input type="hidden" name="url" value="<?=url()->previous()?>">

                            <div class="w-100 text-center">
                                <button type="submit" class="btn w-35 lang" data-section="files" data-article="button_editComment">
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