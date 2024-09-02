@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show() }} lang" data-section="update" data-article="add_video">{{ __("Carica un video") }}</div>

                <div class="card-body {{ Themes::show() }}">
                    <form method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data" class="form_{{ Themes::show() }}">
                        @csrf

                        <input type="hidden" class="lang_validate" name="text_validate" value=""> 

                        <div class="mb-3 d-flex flex-row justify-content-center gap-3 align-items-center">

                                <div>
                                   <input id="video" type="file" class="form-control @error('video') is-invalid @enderror change_file" name="video" style="display: none;">
                                   <button type="button" class="btn  edit_{{ Themes::show() }} ms-0 lang" onclick="document.querySelector('#video').click()"  data-section="update" data-article="chose_file">
                                      Scegli File 
                                   </button> 

                                <span class="fs-5 name_file lang" data-section="update" data-article="no_file">
                                    Nessun file selezionato
                                </span>

                                
                              
                                @error('video')
                                    <span class="row invalid-feedback fs-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 


                                </div>

                        </div>

                        <div class="input-group row">
                            <label class="col-12 fs-5 lang" data-section="update" data-article="description_video">Descrivi il tuo video</label>
                            <textarea class="form-control  @error('description') is-invalid @enderror col-12 ms-2 rounded" aria-label="With textarea" name="description" required></textarea>
                       
                               @error('description')
                                    <span class="row invalid-feedback fs-5 text-center" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                       
                        </div>
 

                        <div class="w-100 text-center mt-3">
                                <button type="submit" class="btn edit_{{ Themes::show() }} lang" data-section="update" data-article="button_video">
                                    {{ __('Carica video') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection




