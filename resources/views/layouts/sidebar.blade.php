<div class="col-4 suggess">
    <div class="d-flex flex-row align-items-center">
        <a class="info" href="{{ route('profile.index') }}"><div
            class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border sidenav-profile-photo">
            <img class="avatar-img" src="{{ asset('avatar/' . Auth::user()->avatar) }}" alt="...">
        </div></a>
        <div class="profile-info ml-3">
            <span class="profile-info-username"><a class="info" href="{{ route('home.profile') }}">{{ Auth::user()->username }}</a></span>
            <span class="profile-info-name"><a class="info" href="{{ route('home.profile') }}">{{ Auth::user()->fullname }}</a></span>
        </div>
    </div>
    <div class="mt-4">
        <div class="d-flex flex-row justify-content-between">
            <p >{{ trans('timeline.suggestion') }}</p>
            <p>{{ trans('timeline.see_all') }}</p>
        </div>
        <div>
            <div class="d-flex flex-row justify-content-between align-items-center mt-3 mb-3">
                <div class="d-flex flex-row align-items-center">
                    <div
                        class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border sugest-profile-photo">
                        <img src="" alt="..." class="avatar-img">
                    </div>
                    <strong class="ml-3 sugest-username">user1</strong>
                </div>
                <button class="btn btn-primary btn-sm p-0 btn-ig ">{{ trans('timeline.follow') }}</button>
            </div>
            <div class="d-flex flex-row justify-content-between align-items-center mt-3 mb-3">
                <div class="d-flex flex-row align-items-center">
                    <div
                        class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border sugest-profile-photo">
                        <img src="" alt="..." class="avatar-img">
                    </div>
                    <strong class="ml-3 sugest-username">user2</strong>
                </div>
                <button class="btn btn-primary btn-sm p-0 btn-ig ">{{ trans('timeline.follow') }}</button>
            </div>
            <div class="d-flex flex-row justify-content-between align-items-center mt-3 mb-3">
                <div class="d-flex flex-row align-items-center">
                    <div
                        class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border sugest-profile-photo">
                        <img src="" alt="..." class="avatar-img">
                    </div>
                    <strong class="ml-3 sugest-username">user3</strong>
                </div>
                <button class="btn btn-primary btn-sm p-0 btn-ig">{{ trans('timeline.follow') }}</button>
            </div>
        </div>
    </div>
</div>
