@extends('app')

@section('title') View Server - @parent @stop
@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">

        <table class="table">
            <caption>Server Info</caption>
            {{-- <thead>
            <tr>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Username</th>
            </tr>
            </thead> --}}
            <tbody>
                <tr>
                    <th scope="row">IP address</th>
                    <td>{{ $server->ip }}</td>
                </tr>
                <tr>
                    <th scope="row">Port</th>
                    <td>{{ $server->port }}</td>
                </tr>
                <tr>
                    <th scope="row">Server state</th>
                    <td>{{ $server->status }}</td>
                </tr>
                <tr>
                    <th scope="row">Owner</th>
                    <td>{{ $server->owner ?: 'N/A' }}</td>
                </tr>
                @if ($server->status == 'Online')
                <tr>
                    <th scope="row">YS version</th>
                    <td>{{ $server->game->version }}</td>
                </tr>
                <tr>
                    <th scope="row">Map</th>
                    <td>{{ $server->game->map }}</td>
                </tr>
                <tr>
                    <th scope="row">Day/night</th>
                    <td>{{ $server->game->weather->is_day ? 'Day' : 'Night' }}</td>
                </tr>
                <tr>
                    <th scope="row">Visibility</th>
                    <td>{{ $server->game->weather->visib }}m</td>
                </tr>
                <tr>
                    <th scope="row">Wind x-axis</th>
                    <td>{{ $server->game->weather->wind_x }}m/s</td>
                </tr>
                <tr>
                    <th scope="row">Wind y-axis</th>
                    <td>{{ $server->game->weather->wind_y }}m/s</td>
                </tr>
                <tr>
                    <th scope="row">Wind z-axis</th>
                    <td>{{ $server->game->weather->wind_z }}m/s</td>
                </tr>
                <tr>
                    <th scope="row">Missiles</th>
                    <td>{{ $server->game->options->missiles ? 'On' : 'Off' }}</td>
                </tr>
                <tr>
                    <th scope="row">Weapons</th>
                    <td>{{ $server->game->options->weapon ? 'On' : 'Off' }}</td>
                </tr>
                <tr>
                    <th scope="row">Blackout</th>
                    <td>{{ $server->game->options->blackout ? 'On' : 'Off' }}</td>
                </tr>
                <tr>
                    <th scope="row">Collisions</th>
                    <td>{{ $server->game->options->collisions ? 'On' : 'Off' }}</td>
                </tr>
                <tr>
                    <th scope="row">Land everywhere</th>
                    <td>{{ $server->game->options->landev ? 'On' : 'Off' }}</td>
                </tr>
                <tr>
                    <th scope="row">Users connected</th>
                    <td>{{ $server->game->players->total }}</td>
                </tr>
                <tr>
                    <th scope="row">Users flying</th>
                    <td>{{ $server->game->players->flying }}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <table class="table">
            <caption>Players</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IFF</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($server->game->users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->iff }}</td>
                    <td>{{ $user->server ? '(Host) ' : '' }}{{ $user->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@stop
