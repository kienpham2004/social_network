@foreach ($users as $user)
    <ul class="dropdown-menu show_suggess_user" \>
        <li>
            <a class="user_suggess" href="
            @if ($user->id != Auth::user()->id)
                {{ route('wall.your_friend', $user->username) }}
            @else
                {{ route('profile.index') }}
            @endif
                " >{{$user->username}}
            </a>
        </li>
    </ul>
@endforeach
