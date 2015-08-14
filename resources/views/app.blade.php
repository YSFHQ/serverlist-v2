<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title') YSFlight Server List @show</title>
    <meta name="keywords" content="ys, ysfs, ysflight, yspilots, flight, simulator, server, list, YSPS, YSC, YSChat, aircraft, sim">
    <meta name="author" content="YSFlight Headquarters">
    <meta name="description" content="Server list of YSFlight servers">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Firebase -->
    <script src="https://cdn.firebase.com/js/client/2.0.2/firebase.js"></script>

    <!-- Firechat -->
    <link rel="stylesheet" href="https://cdn.firebase.com/libs/firechat/2.0.1/firechat.min.css" />
    <script src="https://cdn.firebase.com/libs/firechat/2.0.1/firechat.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="{{ asset('assets/ico/favicon.ico') }}">
</head>
<body>
    @include('partials.nav')

    <div class="container-fluid">
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

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
