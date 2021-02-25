@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/time_line.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="mt-4">
        <div class="container d-flex justify-content-center">
            <div class="col-9">
                <div class="row">
                    <div class="modal fade" id="listhistory" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ trans('profile.activities') }}</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($listHistory as $history)
                                        @if ($history->notify !== "")
                                            {{ trans(json_decode($history->notify)->message) . " "  . json_decode($history->notify)->user_name }}  
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('profile.close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('layouts.post')
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
