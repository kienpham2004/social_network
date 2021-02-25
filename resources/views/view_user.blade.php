@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/view_user.css') }}">
@endsection

@section('content')
<div class="modal fade" id="listhistory" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('profile.activities') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @foreach ($listHistory as $history)
                    @if ($history->notify !== "")
                        {{ trans(json_decode($history->notify)->message) . " "  . json_decode($history->notify)->user_name }}  
                        <hr>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('profile.close') }}</button>
            </div>
        </div>
    </div>
</div>
<header>
    @foreach ($posts as $post)
        @if ($loop->first)
            <div class="container">
                <div class="profile">
                    <div class="profile-image">
                        <img src="{{ asset('avatar/'. $post->user->avatar) }}" alt="">
                    </div>
                    <div class="profile-user-settings btn-setting">
                        <h1 class="profile-user-name">{{ $post->user->username }}</h1>
                        <div class="follow_action">
                            @if ($checkFollow)
                                <button type="button" class="btn profile-edit-btn btn-unfollow" data-token="{{ csrf_token() }}" 
                                    id="btn-unfollow{{ $post->user->id }}" data-id={{ $post->user->id }} >{{ trans('profile.unfollow') }}</button>
                            @else
                                <button type="button" class="btn profile-edit-btn btn-follow" data-token="{{ csrf_token() }}" 
                                    id="btn-follow{{ $post->user->id }}" data-id={{ $post->user->id }} >{{ trans('profile.follow') }}</button>
                            @endif
                        </div>
                    </div>
                    <div class="profile-stats">
                        <ul>
                            @foreach ($counts as $item)
                                <li><span class="profile-stat-count">{{ count($posts) }}<span> {{ trans('profile.posts') }}</li>
                                <li><span class="profile-stat-count span-follower" 
                                    data-countfollower="{{ $item->follower_count}}">{{ $item->follower_count}}</span> {{ trans('profile.followers') }}</li>
                                <li><span class="profile-stat-count span-follwing" 
                                    data-countfollowing="{{ $item->following_count }}">{{ $item->following_count }}</span> {{ trans('profile.following') }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="profile-bio" >
                        <p><span class="profile-real-name">{{ $post->user->fullname }}</span></p>
                        <p><span>{{ $post->user->description }}</span></p>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</header>
<main>   
    <br>
    <div class="container">
        <div class="gallery">
            @foreach ($posts as $post)
                <div class="gallery-item" tabindex="0">
                    <a class="show-post" href="{{ route('profile.show-post', $post->id) }}" >
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
