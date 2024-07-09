<div class="comments_total">
    <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn btn-warning fs-5" data-type="image">
       <span class="lang" data-section="files" data-article="total_comments"> Commenti</span>({{ count($image->comments) }})  <i class="fa fa-caret-down" aria-hidden="true"></i>
    </a>
</div>