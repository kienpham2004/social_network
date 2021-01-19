@foreach ($users as $user)
    <ul class="dropdown-menu" id="show-user-search-navbar">
        <li class="list-user">
            <div
                class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border topbar-profile-photo profile-image">
                <img class="img-profile" src="{{ asset(config('url.url_avatar'). $user->avatar) }}" alt="...">
            </div>
            &nbsp;&nbsp;
            <a class="view_user_when_search" href="
                @if ($user->id != Auth::user()->id)
                    {{ route('wall.your_friend', $user->username) }}
                @else
                    {{ route('profile.index') }}
                @endif
                ">{{ $user->username }}
            </a>
        </li>
    </ul>
@endforeach
