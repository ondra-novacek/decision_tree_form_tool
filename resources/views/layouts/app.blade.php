<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>App Name - @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        {{-- @section('content')
            This is the master sidebar.
        @show --}}

        <div class="container">
            @yield('content')
        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>