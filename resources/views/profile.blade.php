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
                            <h5 class="modal-title" id="exampleModalLabel">{{ trans('profile.activity') }}</h5>
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
                <div class="profile-image">
                    {{-- avatar --}}
                    <img src="{{ asset('avatar/'. Auth::user()->avatar) }}" alt="">
                    <button type="button" class="btn btn-primary btn-changeavt" data-toggle="modal" 
                        id="edit-avatar" data-target="#exampleModal">
                        <i class="fas fa-camera"></i>
                    </button>
                    {{-- modal --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" 
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ trans('profile.upload_avatar') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="file" name="avatarFile" onchange="loadPreview(this);" id="profile_image">
                                        @error('avatarFile')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <img id="preview_img" src="" class="previewImage"/>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-submit">{{ trans('profile.save_change') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-user-settings">
                    <h1 class="profile-user-name">{{ Auth::user()->username }}</h1>
                    <button class="btn profile-edit-btn" id="btn-setting">{{ trans('profile.edit_profile') }}</button>
                </div>
                <div class="profile-stats">
                    <ul>
                        <li><span class="profile-stat-count">3<span> {{ trans('profile.posts') }}</li>
                        <li>
                            <a href="" class="profile-stat-count" type="button" data-toggle="modal" 
                                data-target="#follower">3</span> {{ trans('profile.followers') }}</a>
                        </li>
                        <li>
                            <a href="" class="profile-stat-count" type="button" data-toggle="modal" 
                                data-target="#following">3</span> {{ trans('profile.following') }}</a>
                        </li>
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
                        <a class="show-post" id="post{{ $post->id }}" href="" >
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
                                
                                    @if ($post->images->count() != config('check_var_on_view.check_1'))
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
