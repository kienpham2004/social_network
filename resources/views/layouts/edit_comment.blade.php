<div class="comment-avt show_comment{{ $commentEdited->id }}" data-id="{{ $commentEdited->id }}">
    <div
        class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border topbar-profile-photo profile-image">
        <img class="avt-in-comment" src="{{ asset(config('url.url_avatar'). $commentEdited->user->avatar) }}" alt="...">
    </div>
    &nbsp;
    <strong>
        <a href="
            @if ($commentEdited->user->username != Auth::user()->username)
                {{ route('wall.your_friend', $commentEdited->user->username) }}
            @else
                {{ route('profile.index') }}
            @endif">{{ $commentEdited->user->username }}
        </a>
    </strong> 
    <span>{{ $commentEdited->content }}</span> 
    <a type="button" class="deleteComment" data-token="{{ csrf_token() }}" data-id="{{ $commentEdited->id }}" value="{{ $commentEdited->id }}">
        <i class="far fa-trash-alt"></i>
    </a>
    <a type="button" class="editComment"  data-id="{{ $commentEdited->id }}"  value="{{ $commentEdited->id }}">
        <i class="far fa-edit"></i>
    </a>
    <div class="formEditComment{{ $commentEdited->id }} form-edit-comment">
        <input type="text" placeholder="{{ $commentEdited->content }}" class="form-control inputEditComment" id="edit{{ $commentEdited->id }}" name="valueEditComment">
        <div class="actionEditPost">
            <button class="submitEditComment" data-token="{{ csrf_token() }}" value="{{ $commentEdited->id }}">save</button>
        </div>
    </div>
</div>
