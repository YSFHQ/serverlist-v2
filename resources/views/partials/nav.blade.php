<nav class="navbar navbar-default navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('index') }}">YSFlight Server List</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ (Request::is('/') ? 'active' : '') }}">
                    <a href="{{ route('index') }}/"><i class="fa fa-home"></i> Home</a>
                </li>
                <!--<li class="{{ (Request::is('map') ? 'active' : '') }} disabled">
                    <a href="{{ route('map') }}">Map</a>
                </li>
                <li class="{{ (Request::is('stats') ? 'active' : '') }} disabled">
                    <a href="{{ route('stats') }}">Stats</a>
                </li>
                <li class="{{ (Request::is('log') ? 'active' : '') }} disabled">
                    <a href="{{ route('log') }}">Log</a>
                </li>
                <li class="{{ (Request::is('help') ? 'active' : '') }} disabled">
                    <a href="{{ route('help') }}">Help</a>
                </li>-->
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="{{ (Request::is('server/create') ? 'active' : '') }}">
                    <a href="{{ route('server.create') }}">Add Server</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
