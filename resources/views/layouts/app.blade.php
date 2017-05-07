<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ys, ysfs, ysflight, yspilots, flight, simulator, server, list, YSPS, YSC, YSChat, aircraft, sim">
    <meta name="author" content="YSFlight Headquarters">
    <meta name="description" content="Server list of YSFlight servers">
    <link rel="shortcut icon" href="{{ asset('assets/ico/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name', 'YSFlight Server List') }}</title>

    <!-- Styles -->
    <link href="https://cdn.firebase.com/libs/firechat/3.0.1/firechat.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        @include('partials.nav')

        <div class="container-fluid">
            @if (env('ALERT_MESSAGE'))
                <div class="alert alert-info" role="alert">
                    {{ env('ALERT_MESSAGE') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>

        @include('partials.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('firechat-scripts')
</body>
</html>