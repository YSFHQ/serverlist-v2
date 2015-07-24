@extends('app')

@section('title') Home - @parent @stop
@section('content')
<div class="row">
    <h3>Servers</h3>
    <div class="table-responsive">
    <table class="table table-hover" id="server-list">
        <thead>
            <tr>
                <th></th>
                <th>Server Name</th>
                <th>IP(:port)</th>
                <th>Map</th>
                <th>Players</th>
                <th>Weather</th>
                <th>Options</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($servers as $server)
            <tr class="{{ $server->status == 'Online' ? 'success' : 'danger' }}">
                <td class="join">
                @if ($server->status == 'Online')
                    <a href="ysflight://{{ $server->ip }}"><img src="img/ys2.png" title="click to connect this server"></a>
                @endif
                </td>
                <td class="name">
                    <a href="{{ route('map', ['id' => $server->id]) }}"><img src="img/flags/{{ strtolower($server->country) }}.gif" title="{{ strtoupper($server->country) }} - Distance to the server: {{ round($server->distance($location), 1) }}mi"></a>
                    <a href="{{ route('server.show', ['id' => $server->id]) }}" title="owner: {{ $server->owner }} | YS version: 20110207">{{ $server->name }}</a>
                    @if (gethostbyname($server->ip)==Request::ip())
                        {!! Form::open(['route' => ['server.destroy', $server->id], 'method' => 'delete']) !!}
                        <div class="btn-group" role="group">
                            {!! link_to_route('server.edit', 'Edit', $server->id, ['class' => 'btn btn-default btn-xs']) !!}
                            <button type="submit" class="btn btn-default btn-xs">Delete</button>
                        </div>
                        {!! Form::close() !!}
                    @endif
                </td>
                <td class="ip">
                    {{ $server->ip }}
                    @if ($server->port != 7915)
                    <span class="text-muted">:{{ $server->port }}</span>
                    @endif
                </td>
                <td class="map">
                @if ($server->status == 'Online')
                    <a href="http://marcjeanmougin.free.fr/ys_servers/index.php?page=mapToLink.php&amp;map={{ $server->game->map }}">{{ $server->game->map }}</a>
                @else
                    N/A
                @endif
                </td>
                <td class="players">
                @if ($server->status == 'Online')
                    <div class="progress">
                        <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="{{ $server->game->players->notflying }}" aria-valuemin="0" aria-valuemax="20" style="width: {{ min($server->game->players->notflying/20, 1) * 100 }}%;">
                            {{ $server->game->players->notflying }}
                        </div>
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ $server->game->players->flying }}" aria-valuemin="0" aria-valuemax="20" style="width: {{ min($server->game->players->flying/20, 1) * 100 }}%;">
                            {{ $server->game->players->flying }}
                        </div>
                    </div>
                @else
                    N/A
                @endif
                </td>
                <td class="weather">
                @if ($server->status == 'Online')
                    <img src="img/{{ $server->game->weather->is_day ? 'day' : 'night' }}.png" title="{{ $server->game->weather->is_day ? 'day' : 'night' }}">
                    <img src="{{ $server->game->weather->weather_img }}" title="visibility: {{ $server->game->weather->visib }}m | wind direction: {{ $server->game->weather->wind_dir }} | wind speed: {{ $server->game->weather->wind_speed }}m/s | windx={{ $server->game->weather->wind_x }} | windy={{ $server->game->weather->wind_x }} | windz={{ $server->game->weather->wind_z }}" />
                @else
                    N/A
                @endif
                </td>
                <td class="options">
                @if ($server->status == 'Online')
                    <img src="img/blackout_{{ $server->game->options->blackout ? 'on' : 'off' }}.png" title="blackout_{{ $server->game->options->blackout ? 'on' : 'off' }}">
                    <img src="img/collisions_{{ $server->game->options->collisions ? 'on' : 'off' }}.png" title="collisions_{{ $server->game->options->collisions ? 'on' : 'off' }}">
                    <img src="img/landev_{{ $server->game->options->landev ? 'on' : 'off' }}.png" title="landev_{{ $server->game->options->landev ? 'on' : 'off' }}">
                    <img src="img/missiles_{{ $server->game->options->missiles ? 'on' : 'off' }}.png" title="missiles_{{ $server->game->options->missiles ? 'on' : 'off' }}">
                    <img src="img/weapon_{{ $server->game->options->weapon ? 'on' : 'off' }}.png" title="weapon_{{ $server->game->options->weapon ? 'on' : 'off' }}">
                    <img src="img/radar.png" title="{{ $server->game->options->radar }}">
                    <img src="img/f3_{{ $server->game->options->f3 ? 'on' : 'off' }}.png" title="F3 view {{ $server->game->options->f3 ? 'on' : 'off' }}">
                @else
                    N/A
                @endif
                </td>
                <td class="clock">
                    <img src="img/clock.png" title="information updated: {{ $server->lastupdated() }}">
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection

@stop
