@extends('layouts.app')

@section('content')
<div class="container">
    <div class="wrapper">
        <div class="header">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="top">
                    <div class="logo">
                        <img src="{{ asset(config('img.img_instagram')) }}" alt="instagram" class="logo_login">
                    </div>
                    <div class="form">
                        <div class="input_field">
                            <input id="email" type="email" class="form-control input @error('email') is-invalid @enderror" name="email" placeholder="{{ trans('log_res.phone_user_email_login') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input_field">
                            <input id="password" type="password" class="form-control input @error('password') is-invalid @enderror" name="password" placeholder="{{ trans('log_res.password') }}" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ trans('log_res.login') }}
                            </button>
                        </div>
                    </div>
                    <div class="or">
                        <div class="line"></div>
                        <p>{{ trans('log_res.or') }}</p>
                        <div class="line"></div>
                    </div>
                    <div class="dif">
                        <div class="fb">
                            <img src="{{ asset(config('img.img_facebook')) }}" alt="facebook">
                            <p>{{ trans('log_res.log_with_fb') }}</p>
                        </div>
                        <div class="forgot">
                            <a href="{{ route('forgot.password') }}">{{ trans('log_res.forgot_pass') }}</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="signup">
                <p>{{ trans('log_res.dont_have_an_account') }}
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ trans('log_res.register') }}</a>
                        </li>
                    @endif
                </p>
            </div>
            <div class="apps">
                <p>{{ trans('log_res.get_app') }}</p>
                <div class="icons">
                    <a href="#"><img src="{{ asset(config('img.img_appstore')) }}" alt="appstore"></a>
                    <a href="#"><img src="{{ asset(config('img.img_googleplay')) }}" alt="googleplay"></a>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="copyright">
                © {{ now()->year }} INSTAGRAM
            </div>
        </div>
    </div>
</div>
@endsection
