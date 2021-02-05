@foreach ($posts as $post)
    <div id="listComment{{ $post->id }}">
        @foreach ($post->comments->slice(config('check_var_on_view.start_fisrt_record_0'), config('check_var_on_view.start_fisrt_record_2')) as $item)
            <div class="item-comment item-comment{{ $item->id }}" >
                <div class="comment-avt show_comment{{ $item->id }}" data-id="{{ $item->id }}" >
                    <div
                        class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border topbar-profile-photo profile-image">
                        <img class="avt-in-comment" src="{{ asset(config('url.url_avatar'). $item->user->avatar) }}" alt="...">
                    </div>
                    &nbsp;
                    <strong>
                        <a href="
                            @if ($item->user->username != Auth::user()->username)
                                {{ route('wall.your_friend', $item->user->username) }}
                            @else
                                {{ route('profile.index') }}
                            @endif">{{ $item->user->username }}
                        </a>
                    </strong>
                    <span>{{ $item->content }}</span>
                    @can('delete', $item)
                        <a type="button" class="deleteComment icon-right" data-token="{{ csrf_token() }}" data-id="{{ $item->id }}" value="{{ $item->id }}">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    @endcan
                    @can('update', $item)
                        <a type="button" class="editComment icon-right" data-id="{{ $item->id }}" value="{{ $item->id }}">
                            <i class="far fa-edit"></i>
                        </a>
                    @endcan
                    <div class="form-none formEditComment{{ $item->id }} form-edit-comment" >
                        <input type="text" class="form-control inputEditComment" id="edit{{ $item->id }}" value="{{ $item->content }}" name="valueEditComment" >
                        <div class="actionEditPost icon-right">
                            <button class="submitEditComment" data-token="{{ csrf_token() }}" value="{{ $item->id }}" >{{ trans('timeline.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <button class="btn p-0 view_comment{{ $post->id }}">
            <span class="text-muted view_comment" id="view_comment{{ $post->id }}" data-paginate="{{ $item->id }}" data-count-comment="{{ $post->comments_count - config('check_var_on_view.count_comment_2') }}" data-post-id="{{ $post->id }}">{{ trans('timeline.view') }} {{ trans('timeline.comments') }}</span>
        </button>
    </div>
@endforeach
