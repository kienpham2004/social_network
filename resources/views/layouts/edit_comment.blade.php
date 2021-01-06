<div class="show_comment{{ $comment->id }}" data-id="{{ $comment->id }}">
    <strong>{{ Auth::user()->username }}</strong> 
    <span>{{ $comment->content }}</span> 
    <a type="button" class="deleteComment" data-token="{{ csrf_token() }}" data-id="{{ $comment->id }}" value="{{ $comment->id }}">
        <i class="far fa-trash-alt"></i>
    </a>
    <a type="button" class="editComment"  data-id="{{ $comment->id }}"  value="{{ $comment->id }}">
        <i class="far fa-edit"></i>
    </a>
    <div class="formEditComment{{ $comment->id }}" >
        <input type="text" class="form-control inputEditComment" id="edit{{ $comment->id }}" name="valueEditComment">
        <div class="actionEditPost">
            <button class="submitEditComment" data-token="{{ csrf_token() }}" value="{{ $comment->id }}">save</button>
        </div>
    </div>
</div>
