@extends('layouts.app')

@section('content')

@if($video->user->id == Auth::user()->id || $video->user->type == 'public' || isFriend::check($video->user->id) )
<?php $detail = true; ?>

<div class="container">

     <div class="navbar navbarCarouselDetail mb-4"> 
        <div class="w-50 ps-3 fs-5 lang" data-section="files" data-article="view_videos"> Scorri i video: </div>    
        <div class="position-relative" style="width: 150px;">
             <button class="carousel-control-prev w-50" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-3" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next w-75" type="button" data-bs-target="#carousel" data-bs-slide="next" >
                <span class="carousel-control-next-icon bg-dark rounded-3" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="content_carusel">

        <div id="carousel" class="carousel slide">
            <div class="content_details carousel-inner">
                <div class="content_row carousel-item active" >


                    <div class="content_files">

                    <?php $type = 'video'; ?>
                        @include('includes.detail_user')

                        <video src="{{ route('videos.show', ['video'=> $video->id]) }}" controls class="d-block w-100" alt="video:detail" style="border-radius: 10px;"></video>

                        <div class="description_detail">
                            <div> {{ $video->description }} </div>
                            @include('like.like_videos')
                        </div>
                    </div>

                    <div class="content_detail">
                        <h3 class="bg-warning lang" data-section="files" data-article="total_comments">Commenti totali</h3>
                        @include('comment.comments_videos')
                    </div>

                    <div class="clearfix"></div>
                </div>

                @foreach($others_videos as $video)
                <div class="content_row carousel-item">

                    <div class="content_files">

                        @include('includes.detail_user')

                        <video src="{{ route('videos.show', ['video'=> $video->id]) }}" controls class="d-block w-100" alt="image_detail" style="border-radius: 10px;"></video>

                        <div class="description_detail">
                            <div> {{ $video->description }} </div>
                            @include('like.like_videos')
                        </div>

                    </div>

                    <div class="content_detail">
                    <h3 class="bg-warning lang" data-section="files" data-article="total_comments">Commenti totali</h3>
                        @include('comment.comments_videos')
                    </div>

                    <div class="clearfix"></div>

                </div>
                @endforeach

            </div>
             
            <!--   bottoni spostati sopra   -->
        </div>

    </div>
</div>

@else        <!--  se il profilo è privato e non si è amici.... -->
   <div class="no_friend {{ Themes::show() }}">
    <h3 class="lang" data-section="files" data-article="no_friend">Questo Utente ha un profilo privato, richiedi la sua amicizia se vuoi vedere i suoi contenuti, per tornare indietro clicca <a href="{{ url()->previous() }}" class="lang" data-section="files" data-article="link">qui</a></h3>
   </div>
@endif

@endsection