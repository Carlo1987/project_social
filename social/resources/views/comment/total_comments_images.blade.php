<div class="comments_total">
    <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="button_comments btn btn-warning fs-5" data-type="image">
        Commenti totali({{ count($image->comments) }})
    </a>
</div>