<div class="comments_total button_query_video">
    <a href="{{ route('video.detail', ['id' => $video->id]) }}" class="btn btn-warning fs-5" data-type="video" data-theme="{{ Themes::show(Auth::user()->id) }}">
       <span  class="lang" data-section="files" data-article="total_comments"> Commenti</span>({{ count($video->comments) }})  <i class="fa fa-caret-down" aria-hidden="true"></i>
    </a>
</div>