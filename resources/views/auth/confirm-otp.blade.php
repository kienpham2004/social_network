
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="wrapper">
            <div class="header">
                <form action="{{ route('confirm_otp', $user->first()->email) }}" method="post">
                    @csrf
                    <div class="top">
                        <div class="logo">
                            <img src="{{ asset(config('img.img_instagram')) }}" alt="instagram" class="logo_login">
                        </div>
                        <div class="form">
                            <h5>{{ trans('log_res.sent_code_otp_to_email') }} <strong>{{ $user->first()->email }}</strong>.</h5>
                            <br>
                            <h5>{{ trans('log_res.confirm_otp') }}</h5>
                            <div class="input_field">
                                <input type="text" class="form-control input" name="otp" 
                                    placeholder="{{ trans('log_res.type_otp') }}" required>
                                @error('otp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ trans('log_res.submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
