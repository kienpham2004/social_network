@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/show_post.css') }}" rel="stylesheet">
@endsection

@section('content')
    @foreach ($post as $item)
        <div class="container-fluid">
            <a href="{{ route('profile.back', $item->id) }}" class="back">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    @endforeach
    <div class="container show-post" >
        @foreach ($post as $item)
            <div class="showPost">
                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                    <div id="caro{{ $item->id }}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($item->images as $image)
                                @if ($image->id == $item->images[0]->id)
                                    <div class="carousel-item active" data-interval="10000">
                                        <img src="{{ asset(config('url.url_image') . $image->photo_url) }}" class="gallery-image d-block w-100" alt="">
                                    </div>
                                @else
                                    <div class="carousel-item" data-interval="10000">
                                        <img src="{{ asset(config('url.url_image') . $image->photo_url) }}" class="gallery-image d-block w-100" alt="">
                                    </div>
                                @endif
                                
                                @if ($item->images->count() != 1)
                                    <a class="carousel-control-prev" href="#caro{{ $item->id }}" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#caro{{ $item->id }}" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only"></span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                    <div>
                        <div class="header">
                            <a href="{{ route('home.profile') }}"
                                class="info">
                                <div class=" p-3">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border border-danger post-profile-photo mr-3">
                                            <img class="avtUser" src="{{ asset(config('url.url_avatar'). $item->user->avatar) }}" alt="...">
                                                <img src="" alt="">
                                        </div>
                                        <span class="font-weight-bold info label-username">
                                            {{ $item->user->username }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <div class="item-header">
                                @can('view', $item)
                                    <div class="btn-group dropleft dropdown">
                                        <button class="btn btn-secondary" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-content show-action-post" aria-labelledby="dropdownMenuButton">
                                            <li id="btn-edit-post"><a class="dropdown-item" type="button" href="#">{{ trans('show_post.edit') }}</a></li>
                                            <form action="{{ route('delete.post', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="dropdown-item" type="submit" onclick="return confirm('You want delete post?')">{{ trans('show_post.delete') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                @endcan
                            </div>    
                        </div>
                        <p class="label-username"><strong>{{ $item->user->username }}</strong> {{ $item->caption }}</p>
                        <form action="" class="form-edit-post" method="post">
                            @csrf
                            @method('patch')
                            <div id="edit-content-post">
                                <input type="text" class="form-control input-edit" value="{{ $item->caption }}" placeholder="{{ trans('show_post.type_a_caption...') }}" name="caption">
                                @error('caption')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="action-post">
                                    <button type="submit" class="btn-save" >{{ trans('show_post.save') }}</button>
                                </div>
                            </div> 
                        </form>
                        <hr>
                        <div class="d-flex flex-row justify-content-between">
                            <ul class="list-inline d-flex flex-row align-items-center m-0">
                                <li class="list-inline-item">
                                    @if ($checkLike)
                                        <button class="btn p-0 button-unlike" data-count="{{ $item->users_count }}" data-token="{{ csrf_token() }}" id="unlike{{ $item->id }}" data-id="{{ $item->id }}">
                                            <svg viewBox="0 0 16 16"
                                                class="fas fa-heart button-icon-unlike" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                            </svg>
                                        </button>
                                    @else
                                        <button class="btn p-0 button-like" data-count={{ $item->users_count }} data-token="{{ csrf_token() }}" id="like{{ $item->id }}" data-id="{{ $item->id }}">
                                            <svg viewBox="0 0 16 16"
                                                class="far fa-heart icon-like button-icon" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                            </svg>
                                        </button>
                                    @endif
                                </li>
                                <li class="list-inline-item ml-2 buttonComment">
                                    <button class="btn p-0">
                                        <svg viewBox="0 0 16 16"
                                            class="far fa-comment button-icon" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <div class="position-relative comment-box">
                            <input type="text" class="form-control w-100 p-3 add_comment input-post{{ $item->id }}" id="commentValue{{ $item->id }}" placeholder="{{ trans('timeline.add_comment') }}" value="" name="comment" autofocus  >
                            <button class="btn btn-primary position-absolute btn-ig send-comment-on-post" type="submit" data-post-id="{{ $item->id }}" disabled>{{ trans('timeline.post') }}</button>
                        </div>
                        <strong class="d-block count-like-post"><span class="count-like{{ $item->id }}">{{ $item->users_count }} </span>
                            @if ($item->users_count > 1)
                                {{ trans('timeline.likes') }}
                            @else
                                {{ trans('timeline.like') }}
                            @endif
                        </strong>
                        <div id="listComment{{ $item->id }}">
                            @foreach ($item->comments as $comment)
                                <div class="item-comment{{ $comment->id }} item-comment-post-detail">
                                    <div class="show_comment{{ $comment->id }}" data-id="{{ $comment->id }}">
                                        <div
                                            class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border topbar-profile-photo profile-image">
                                            <img src="{{ asset(config('url.url_avatar') . $comment->user->avatar) }}" class="avt-in-comment" alt="...">
                                        </div>
                                        &nbsp;
                                        <strong>
                                            <a href="
                                                @if ($comment->user->username != Auth::user()->username)
                                                    {{ route('wall.your_friend', $comment->user->username) }}
                                                @else
                                                    {{ route('home.profile') }}
                                                @endif">{{ $comment->user->username }}
                                            </a>
                                        </strong>
                                        <span>{{ $comment->content }}</span>
                                        @if ($item->user_id === Auth::user()->id)
                                            @can('delete', $item)
                                                <a type="button" class="deleteComment item-comment-delete" data-token="{{ csrf_token() }}" data-id="{{ $comment->id }}" value="{{ $comment->id }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            @endcan
                                        @else
                                            @can('delete', $comment)
                                                <a type="button" class="deleteComment item-comment-delete" data-token="{{ csrf_token() }}" data-id="{{ $comment->id }}" value="{{ $comment->id }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            @endcan
                                        @endif
                                        @can('update', $comment)
                                            <a type="button" class="editComment item-comment-delete" data-id="{{ $comment->id }}" value="{{ $comment->id }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endcan
                                        <div class="formEditComment{{ $comment->id }} form-edit-comment">
                                            <input type="text" class="form-control inputEditComment" id="edit{{ $comment->id }}" value="{{ $comment->content }}" name="valueEditComment">
                                            <div class="actionEditPost">
                                                <button class="submitEditComment" data-token="{{ csrf_token() }}" value="{{ $comment->id }}" >{{ trans('timeline.save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('js')
    <script language="JavaScript" type="text/javascript" src="{{ mix('js/show_post.js')}}"></script>
@endsection
