<nav class="navbar navbar-default navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">YSFlight Server List</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ (Request::is('/') ? 'active' : '') }}">
                    <a href="{!! URL::to('') !!}"><i class="fa fa-home"></i> Home</a>
                </li>

                <li class="{{ (Request::is('map') ? 'active' : '') }}">
                    <a href="{!! URL::to('map') !!}">Map</a>
                </li>
                <li class="{{ (Request::is('stats') ? 'active' : '') }}">
                    <a href="{!! URL::to('stats') !!}">Stats</a>
                </li>
                <li class="{{ (Request::is('log') ? 'active' : '') }}">
                    <a href="{!! URL::to('log') !!}">Log</a>
                </li>
                <li class="{{ (Request::is('help') ? 'active' : '') }}">
                    <a href="{!! URL::to('help') !!}">Help</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="{{ (Request::is('add-server') ? 'active' : '') }}">
                    <a href="{!! URL::to('add-server') !!}">Add Server</a>
                </li>
                <li class="{{ (Request::is('edit-server') ? 'active' : '') }}">
                    <a href="{!! URL::to('edit-server') !!}">Edit Server</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
