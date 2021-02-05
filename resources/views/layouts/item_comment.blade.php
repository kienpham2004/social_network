<div class="item-comment item-comment{{ $comment->id }}">
    <div class="comment-avt show_comment{{ $comment->id }}" data-id="{{ $comment->id }}">
        <div
            class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border topbar-profile-photo profile-image">
            <img class="avt-in-comment" src="{{ asset(config('url.url_avatar'). $comment->user->avatar) }}" alt="...">
        </div>
        &nbsp;
        <strong>
            <a href="
                @if ($comment->user->username != Auth::user()->username)
                    {{ route('wall.your_friend', $comment->user->username) }}
                @else
                    {{ route('profile.index') }}
                @endif">{{ $comment->user->username }}
            </a>
        </strong> 
        <span>{{ $comment->content }}</span> 
        <a type="button" class="deleteComment" data-token="{{ csrf_token() }}" data-id="{{ $comment->id }}" value="{{ $comment->id }}">
            <i class="far fa-trash-alt"></i>
        </a>
        <a type="button" class="editComment" data-id="{{ $comment->id }}"  value="{{ $comment->id }}">
            <i class="far fa-edit"></i>
        </a>
        <div class="formEditComment formEditComment{{ $comment->id }}">
            <input type="text" class="form-control inputEditComment" id="edit{{ $comment->id }}" name="valueEditComment">
            <div class="actionEditPost">
                <button class="submitEditComment" data-token="{{ csrf_token() }}" value="{{ $comment->id }}">save</button>
            </div>
        </div>
    </div>
</div>
