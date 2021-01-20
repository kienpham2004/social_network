@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('profile')
    <header>
        <div class="container">
            <div class="modal fade" id="listHistory" tabindex="-1" role="dialog" 
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ trans('profile.activities') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="profile">
                @include('layouts.avatar')
                <div class="profile-user-settings">
                    <h1 class="profile-user-name">{{ Auth::user()->username }}</h1>
                    <button class="btn profile-edit-btn" id="btn-setting">{{ trans('profile.edit_profile') }}</button>
                </div>
                <div class="profile-stats">
                    <ul>
                        @foreach ($counts as $item)
                        <li><span class="profile-stat-count">{{ count($posts->toArray()) }}<span> {{ trans('profile.posts') }}</li>
                        <li><a href="" class="profile-stat-count show-follower" type="button" data-toggle="modal" data-target="#follower" >{{ $item->follower_count }}</span> {{ trans('profile.followers') }}</a></li>
                        <li><a href="" class="profile-stat-count show-following" type="button" data-toggle="modal" data-target="#following">{{ $item->following_count }}</span> {{ trans('profile.following') }}</a></li>
                                {{-- follower --}}
                        <div class="modal" id="follower">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title">{{ trans('profile.follower_list') }}</h1>
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="line-height">
                                            @foreach ($followers as $item)
                                                <div class="flex-follower">
                                                    <div
                                                        class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border topbar-profile-photo profile-image">
                                                        <img src="{{ asset(config('url.url_avatar') . $item->avatar) }}" class="avt-in-list" alt="...">
                                                    </div>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a href="{{ route('wall.your_friend', $item->username) }}">{{$item->username}}
                                                    </a>
                                                </div>
                                                <hr>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                {{-- follwing --}}
                        <div class="modal" id="following">
                            <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title">{{ trans('profile.following_list') }}</h1>
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                                <div class="modal-body">
                                    <div class="line-height">
                                        @foreach ($following as $item)
                                            <div class="flex-follower">
                                                <div
                                                    class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border topbar-profile-photo profile-image">
                                                    <img src="{{ asset('avatar/'. $item->avatar) }}" class="avt-in-list" alt="...">
                                                </div>
                                                &nbsp;
                                                &nbsp;
                                                <a href="{{ route('wall.your_friend', $item->username) }}">{{$item->username}}
                                                </a>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                </div>   
                            </div>
                            </div>
                        </div>
                    @endforeach
                    </ul>
                </div>
                <div class="profile-bio">
                    <p><span class="profile-real-name">{{ Auth::user()->fullname }}</span></p> 
                    <p><span>{{ Auth::user()->description }}</span></p>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <button type="button" data-toggle="modal" data-target="#modal-upload-post" 
                class="btn btn-status">{{ trans('profile.what_do_you_think,') }} {{ Auth::user()->fullname }}</button>
            @error('caption')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('imageFile')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="modal fade" id="modal-upload-post" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLongTitle">{{ trans('profile.what_do_you_think,') }} {{ Auth::user()->fullname }}</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('profile.post_status') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <textarea class="form-control" name="caption" id="upload-comment" rows="5"></textarea>
                                <br>
                                <div class="user-image mb-3 text-center">
                                    <div class="imgPreview"></div>
                                </div> 
                                <input type="file" name="imageFile[]" class="form-control-file" id="upload-file-image" multiple> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">{{ trans('profile.close') }}</button>
                                <button type="Submit" class="btn btn-primary btn-submit">{{ trans('profile.post') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="gallery">
                @foreach ($posts as $post)
                    <div class="gallery-item" tabindex="0">
                        {{ $post->id }}
                        <a class="show-post" id="post{{ $post->id }}" href="{{ route('profile.show-post', $post->id) }}" >
                            <i class="fas fa-heart"></i>
                                <div class="countLike">{{ $post->users_count }}</div>
                            <i class="fas fa-comment"></i>
                                <div class="countComment">{{ $post->comments_count }}</div>
                        </a>
                        <div id="caro{{ $post->id }}" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($post->images as $item)
                                    @if ($item->id == $post->images[0]->id)
                                        <div class="carousel-item active" data-interval="10000">
                                            <img src="{{ asset('image/' . $item->photo_url) }}" class="gallery-image d-block w-100" alt="">
                                        </div>
                                    @else
                                        <div class="carousel-item" data-interval="10000">
                                            <img src="{{ asset('image/' . $item->photo_url) }}" class="gallery-image d-block w-100" alt="">
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
                @endforeach
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script language="JavaScript" type="text/javascript" src="{{ mix('js/profile.js')}}"></script>
@endsection
