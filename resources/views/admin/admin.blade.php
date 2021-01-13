<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('admin.admin') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('bower_components/jquery/dist/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/font-awesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bower_components/template-admin/vendor/fontawesome-free/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('bower_components/template-admin/css/sb-admin-2.min.css') }}" type="text/css">
    <script src="{{ asset('bower_components/font-awesome/js/all.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="{{ asset('js/admin-block.js') }}" defer></script>
</head>
<body id="page-top">
    <div id="wrapper">
        @include('admin.side-bar')
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.header')
                @yield('content')
            </div>
        </div>
       
    </div>
</body>
</html>
