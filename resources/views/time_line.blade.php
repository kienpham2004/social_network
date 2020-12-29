@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/time_line.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="mt-4">
        <div class="container d-flex justify-content-center">
            <div class="col-9">
                <div class="row">
                    @include('layouts.post')
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
