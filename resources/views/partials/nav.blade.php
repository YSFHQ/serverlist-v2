<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">YSFlight Server List</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ (Request::is('/') ? 'active' : '') }}" href="{{ route('index') }}">Servers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (Request::is('server/create') ? 'active' : '') }}" href="{{ route('server.create') }}">Add Server</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
