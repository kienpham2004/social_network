
@foreach ($posts as $post) 
<div class="d-flex flex-column mt-4 mb-4 post_user">
    <div class="card">
        <a href="
            @if ($post->user->id != Auth::user()->id)
                {{ route('wall.your_friend', $post->user->username) }}
            @else
                {{ route('home.profile') }}
            @endif
        " 
            class="info">
                <div class="card-header p-3 header-post">
                    <div class="d-flex flex-row align-items-center">
                        <div class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border border-danger post-profile-photo mr-3">
                            <img class="avatar-img" src="{{ asset(config('url.url_avatar') . $post->user->avatar) }}" alt="...">
                        </div>
                        <span class="font-weight-bold info">
                            {{ $post->user->username }}
                        </span>
                    </div>
                </div>
        </a>
        <div class="card-body p-0">
                <div class="embed-responsive">
                    <div id="caro{{ $post->id }}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($post->images as $item)
                                @if ($item->id == $post->images[0]->id)
                                    <div class="carousel-item active" data-interval="10000">
                                        <img src="{{ asset(config('url.url_image') . $item->photo_url) }}" class="gallery-image d-block w-100" alt="">
                                    </div>
                                @else
                                    <div class="carousel-item" data-interval="10000">
                                        <img src="{{ asset(config('url.url_image') . $item->photo_url) }}" class="gallery-image d-block w-100" alt="">
                                    </div>
                                @endif
                                
                                @if ($post->images->count() != config('check_var_on_view.count_image_1'))
                                    <a class="carousel-control-prev" href="#caro{{ $post->id }}" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#caro{{ $post->id }}" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only"></span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            <div class="d-flex flex-row justify-content-between pl-3 pr-3 pt-3 pb-1">
                <ul class="list-inline d-flex flex-row align-items-center m-0">
                    <li class="list-inline-item">                 
                        @if (in_array($post->id, $likeArr))
                            <button class="btn p-0 button-unlike" data-user-id="{{ $post->user->id }}" data-count="{{ $post->users_count }}" data-token="{{ csrf_token() }}" id="unlike{{ $post->id }}" data-id="{{ $post->id }}">
                                <svg class="icon" width="1.6em" height="1.6em" viewBox="0 0 16 16"
                                    class="fas fa-heart" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                </svg>
                            </button>
                        @else
                            <button class="btn p-0 button-like" data-user-id="{{ $post->user->id }}" data-count="{{ $post->users_count }}" data-token="{{ csrf_token() }}" id="like{{ $post->id }}" data-id="{{ $post->id }}">
                                <svg class="icon" width="1.6em" height="1.6em" viewBox="0 0 16 16"
                                    class="far fa-heart icon-like" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                </svg>
                            </button>
                        @endif
                    </li>
                    <li class="list-inline-item ml-2">
                        <button class="btn p-0">
                            <svg class="icon" width="1.6em" height="1.6em" viewBox="0 0 16 16"
                                class="far fa-comment" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="pl-3 pr-3 pb-2">
                <strong class="d-block"><span class="count-like{{ $post->id }}">{{ $post->users_count }} </span>
                    @if ($post->users_count > config('check_var_on_view.count_comment_1'))
                        {{ trans('timeline.likes') }}
                    @else
                        {{ trans('timeline.like') }}
                    @endif
                </strong>
                <p><strong>{{ $post->user->username }}</strong> {{ $post->caption }}</p>
                <hr>
                @if ($post->comments_count > config('check_var_on_view.count_comment_2'))
                    <button class="btn p-0 view_comment{{ $post->id }}">
                        <span class="text-muted view_comment" id="view_comment{{ $post->id }}" data-post-id="{{$post->id }}">{{ trans('timeline.view') }} {{ $post->comments_count - config('check_var_on_view.count_comment_2') }} {{ trans('timeline.comments') }}</span>
                    </button>
                @endif
                <div id="listComment{{ $post->id }}">
                    @foreach ($post->comments->slice(config('check_var_on_view.start_fisrt_record_0'), config('check_var_on_view.last_record_2')) as $item)
                        <div class="item-comment item-comment{{ $item->id }}">
                            <div class="comment-avt show_comment{{ $item->id }}" data-id="{{ $item->id }}">
                                <div
                                    class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border topbar-profile-photo profile-image">
                                    <img class="avt-in-comment" src="{{ asset(config('url.url_avatar') . $item->user->avatar) }}" alt="...">
                                </div>
                                &nbsp;
                                <strong>
                                    <a href="
                                        @if ($item->user->username != Auth::user()->username)
                                            {{ route('wall.your_friend', $item->user->username) }}
                                        @else
                                            {{ route('home.profile') }}
                                        @endif">{{ $item->user->username }}
                                    </a>
                                </strong>
                                <span>{{ $item->content }}</span>
                                @can('delete', $item)
                                    <a type="button" class="deleteComment" data-token="{{ csrf_token() }}" data-id="{{ $item->id }}" value="{{ $item->id }}">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                @endcan
                                @can('update', $item)
                                    <a type="button" class="editComment" data-id="{{ $item->id }}" value="{{ $item->id }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                <div class="formEditComment{{ $item->id }} form-edit-comment">
                                    <input type="text" class="form-control inputEditComment" id="edit{{ $item->id }}" value="{{ $item->content }}" name="valueEditComment">
                                    <div class="actionEditPost" >
                                        <button class="submitEditComment" data-token="{{ csrf_token() }}" value="{{ $item->id }}" >{{ trans('timeline.save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="position-relative comment-box">
                <input type="text" class="form-control w-100 p-3 add_comment input-post{{ $post->id }}" id="commentValue{{ $post->id }}" placeholder="{{ trans('time_line.add_comment') }}" value="" name="comment" autofocus  >
                <button class="btn btn-primary position-absolute btn-ig send-comment-on-post send-comment{{ $post->id }}" type="submit" data-post-id="{{ $post->id }}">{{ trans('timeline.post') }}</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($posts as $post)
    @if ($loop->last)
        <button type="button" class="btn btn-primary btn-loadmore" value="{{ $post->id }}">{{ trans('timeline.load_more') }}</button>
    @endif
@endforeach
