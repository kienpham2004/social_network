
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="wrapper">
        <div class="header">
            <form action="{{ route('get_email') }}" method="post">
                @csrf
                @method('patch')
                <div class="top">
                    <div class="logo">
                        <img src="{{ asset(config('img.img_instagram')) }}" alt="instagram" class="logo_login">
                    </div>
                    <div class="form">
                        <div class="input_field">
                            <h4>{{ trans('log_res.email_confirm') }}</h4>
                            <input id="email" type="email" class="form-control input" name="email" 
                                placeholder="{{ trans('log_res.email_address') }}" value="{{ old('email') }}" 
                                required autocomplete="email">                            
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
