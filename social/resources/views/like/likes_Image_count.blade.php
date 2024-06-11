<div class="likes_count">
        (<span class="count">{{ count($image->likes) }}</span>)
        
        @if(count($image->likes) != 0)
        <ul>

            @foreach($image->likes as $like)
            <li class="likes_users" data-imageID="{{ $image->id }}">
                <div>
                    <img src="{{ route('getAvatar', ['avatar' => $like->user->img]) }}">
                </div>
                <div>
                    <a href="{{ route('users.show', ['user'=> $like->user_id]) }}">
                        {{ '@'.$like->user->nick }}
                    </a>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </div>