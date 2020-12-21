@extends('layouts.app')

@section('content')
<div class="container">
    <div class="wrapper">
        <div class="header">
            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="top">
                    <div class="logo">
                        <img src="{{ asset(config('img.img_instagram')) }}" alt="instagram" class="logo_login">
                    </div>
                    <div class="form">
                        <div class="input_field">
                            <input id="name" type="text" class="form-control input @error('username') is-invalid @enderror" 
                                name="username" value="{{ old('username') }}" required autocomplete="username" 
                                placeholder="{{ trans('log_res.enter_username') }}" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="input_field">
                            <input id="email" type="email" class="form-control input @error('email') is-invalid @enderror" 
                                name="email" placeholder="{{ trans('log_res.enter_email') }}" 
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="input_field">
                            <input id="password" type="password" class="form-control input @error('password') is-invalid @enderror" 
                                name="password" placeholder="{{ trans('log_res.password') }}" required 
                                autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="input_field">
                            <div>
                                <input id="password-confirm" type="password" class="form-control input" 
                                    name="password_confirmation" placeholder="{{ trans('log_res.confirm_pass') }}" 
                                    required autocomplete="new-password">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ trans('log_res.register') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="footer">
            <div class="copyright">
                © {{ now()->year }} INSTAGRAM
            </div>
        </div>
    </div>
</div>

@endsection
