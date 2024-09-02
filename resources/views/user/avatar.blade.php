@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show() }} lang" data-section="update" data-article="chose_avatar">{{ __("Cambia immagine del profilo") }}</div>

                <div class="card-body {{ Themes::show() }}">
                    <form method="POST" action="{{ route('updateAvatar') }}" enctype="multipart/form-data"  class="form_{{ Themes::show() }}">
                        @csrf

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="mb-3 d-flex flex-row justify-content-center gap-3 align-items-center">

                            <div>
                                <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror change_file"  name="avatar" style="display: none;">
                                <button type="button" class="btn  edit_{{ Themes::show() }} ms-0 lang" onclick="document.querySelector('#avatar').click()"  data-section="update" data-article="chose_file">
                                   Scegli File 
                                </button> 
                         
                                <span class="fs-5 name_file lang" data-section="update" data-article="no_file">
                                    Nessun file selezionato
                                </span>


                                @error('avatar')
                                    <span class="row invalid-feedback fs-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 


                            </div>

                        </div>

                        <div class="w-100 text-center">
                                <button type="submit" class="btn edit_{{ Themes::show() }} lang" data-section="update" data-article="button_avatar">
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


