<div class="col-4 suggess">
    <div class="d-flex flex-row align-items-center">
        <a class="info" href="{{ route('profile.index') }}"><div
            class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border sidenav-profile-photo">
            <img class="avatar-img" src="{{ asset('avatar/' . Auth::user()->avatar) }}" alt="...">
        </div></a>
        <div class="profile-info ml-3">
            <span class="profile-info-username"><a class="info" href="{{ route('profile.index') }}">{{ Auth::user()->username }}</a></span>
            <span class="profile-info-name"><a class="info" href="{{ route('profile.index') }}">{{ Auth::user()->fullname }}</a></span>
        </div>
    </div>
    <div class="mt-4">
        <div class="d-flex flex-row justify-content-between">
            <p class="text-suggess">{{ trans('timeline.suggestion') }}</p>
        </div>
        <div>
            @foreach ($suggessForYou->slice(config('check_var_on_view.start_fisrt_record_0'), config('check_var_on_view.last_record_3')) as $item)
                @if ($item->username != Auth::user()->username)
                    @if (!$item->check == config('check_var_on_view.check_followed'))
                        <div class="d-flex flex-row justify-content-between align-items-center mt-3 mb-3">
                            <a class="username-suggess" href="{{ route('wall.your_friend', $item->username) }}">
                                <div class="d-flex flex-row align-items-center">
                                    <div
                                        class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border sugest-profile-photo">
                                        <img class="avatar-img" src="{{ asset(config('url.url_avatar'). $item->avatar) }}" alt="">
                                    </div>
                                    <strong class="ml-3 sugest-username">{{ $item->username }}</strong>
                                </div>
                            </a>
                            <strong><span class="span-follow">{{ trans('profile.follow') }}</a></span>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>
