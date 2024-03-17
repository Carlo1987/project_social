@extends('layouts.app')

@section('content')


<div class="container container_normal d-flex justify-content-between">

    <div class="content_images">
        <div class="titles titles_{{ Themes::show(Auth::user()->id) }} btn">
            <h3>Immagini</h3>
        </div>

        @include('image.index_images')
    </div>



    <div class="content_videos">
        <div class="titles titles_{{ Themes::show(Auth::user()->id) }} btn">
            <h3>Video</h3>
        </div>

        @include('video.index_videos')
    </div>

</div>





<div class="container container_responsive w-100">

    <div class="nav_responsive fixed-top nav_{{ Themes::show(Auth::user()->id) }} z-1">
        <div id="button_images_responsive" class="titles_{{ Themes::show(Auth::user()->id) }}">  Immagini   </div>
        <div id="button_videos_responsive" class="titles_{{ Themes::show(Auth::user()->id) }}">  Video </div>
    </div>

    <div class="content_images" id="images_responsive">  
        @include('image.index_images')
    </div>



    <div class="content_videos" id="videos_responsive">  
        @include('video.index_videos')
    </div>

</div>


@endsection