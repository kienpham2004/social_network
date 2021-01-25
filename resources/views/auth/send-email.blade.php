
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="wrapper">
            <div class="header">
                <form action="{{ route('reset_password', $user->first()->email) }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="top">
                        <div class="logo">
                            <img src="{{ asset(config('img.img_instagram')) }}" alt="instagram" class="logo_login">
                        </div>
                        <div class="form">
                            <div class="input_field">
                                <input id="email" type="email" class="form-control input" name="email" 
                                    value="{{ $user->first()->email }}" readonly>
                            </div>
                            <div class="input_field">
                                <input id="email" type="password" class="form-control input" name="password" 
                                    placeholder="{{ trans('log_res.password') }}" value="{{ old('email') }}" required>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input_field">
                                <input id="password" type="password" class="form-control input" name="confirm-password" 
                                    placeholder="{{ trans('log_res.confirm_pass') }}" required>
                                    @error('confirm-password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ trans('show_post.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
