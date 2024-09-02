

<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasChat_{{ $chat['friend_id'] }}" aria-labelledby="offcanvasScrollingChat_{{ $chat['friend_id'] }}">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title w-100 text-center text-primary fs-3" id="offcanvasScrollingChat_{{ $chat['friend_id'] }}">   <i class="fa fa-facebook-square" aria-hidden="true"></i>   Chat con {{ $chat['friend_name'] }}  </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body bodyChat">
        @include('chat.chat')
    </div>
</div>

