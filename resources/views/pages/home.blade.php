@extends('app')

@section('title') Home - @parent @stop
@section('content')
<div class="row">
    <h3>Servers</h3>
    <table class="table table-hover" id="server-list">
        <thead>
            <tr>
                <th>Join</th>
                <th>Server Name</th>
                <th>IP:port</th>
                <th>Map</th>
                <th>Players</th>
                <th>Weather</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($servers as $server)
            @if ($server->status == 'online')
            <tr class="success">
                <td class="join">
                    <a href="ysflight://{{ $server->ip }}"><img src="img/ys2.png" title="click to connect this server"></a>
                </td>
                <td class="name">
                    <a href="/map?server={{ $server->id }}"><img src="img/flags/{{ strtolower($server->country) }}.gif" title="{{ strtoupper($server->country) }} - Distance to the server: 9878km"></a>
                    <a href="/server/{{ $server->id }}" title="owner: {{ $server->owner }} | YS version: 20110207">{{ $server->name }}</a>
                </td>
                <td class="ip">{{ $server->ip }}<span class="text-muted">:{{ $server->port }}</span></td>
                <td class="map"><a href="http://marcjeanmougin.free.fr/ys_servers/index.php?page=mapToLink.php&amp;map={{ $server->game->map }}">{{ $server->game->map }}</a></td>
                <td class="players">
                    <div class="progress">
                        <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="{{ $server->game->players->notflying }}" aria-valuemin="0" aria-valuemax="20" style="width: {{ min($server->game->players->notflying/20, 1) }}%;">
                            {{ $server->game->players->notflying }}
                        </div>
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ $server->game->players->flying }}" aria-valuemin="0" aria-valuemax="20" style="width: {{ min($server->game->players->flying/20, 1) }}%;">
                            {{ $server->game->players->flying }}
                        </div>
                    </div>
                </td>
                <td class="weather">
                    <img src="img/{{ $server->game->is_day ? 'day' : 'night' }}.png" title="{{ $server->game->weather->is_day ? 'day' : 'night' }}">
                    <img src="{{ $server->game->weather->weather_img }}" title="visibility: {{ $server->game->weather->visib }}m | wind direction: {{ $server->game->weather->wind_dir }} | wind speed: {{ $server->game->weather->wind_speed }}m/s | windx={{ $server->game->weather->wind_x }} | windy={{ $server->game->weather->wind_x }} | windz={{ $server->game->weather->wind_z }}" />
                </td>
                <td class="options">
                    <img src="img/blackout_{{ $server->game->options->blackout ? 'on' : 'off' }}.png" title="blackout_{{ $server->game->options->blackout ? 'on' : 'off' }}">
                    <img src="img/collisions_{{ $server->game->options->collisions ? 'on' : 'off' }}.png" title="collisions_{{ $server->game->options->collisions ? 'on' : 'off' }}">
                    <img src="img/landev_{{ $server->game->options->landev ? 'on' : 'off' }}.png" title="landev_{{ $server->game->options->landev ? 'on' : 'off' }}">
                    <img src="img/missiles_{{ $server->game->options->missiles ? 'on' : 'off' }}.png" title="missiles_{{ $server->game->options->missiles ? 'on' : 'off' }}">
                    <img src="img/weapon_{{ $server->game->options->weapon ? 'on' : 'off' }}.png" title="weapon_{{ $server->game->options->weapon ? 'on' : 'off' }}">
                    <img src="img/radar.png" title="RADARALTI 304.80m | show player names within 4000m">
                    <img src="img/f3_{{ $server->game->options->f3 ? 'on' : 'off' }}.png" title="F3 view {{ $server->game->options->f3 ? 'on' : 'off' }}">
                </td>
            </tr>
            @else
            <tr class="danger">
                <td class="join"></td>
                <td class="name">
                    <a href="/map?server={{ $server->id }}"><img src="img/flags/{{ strtolower($server->country) }}.gif" title="{{ strtoupper($server->country) }} - Distance to the server: 9878km"></a>
                    <a href="/server/{{ $server->id }}" title="owner: {{ $server->owner }}">{{ $server->name }}</a>
                </td>
                <td class="ip">{{ $server->ip }}<span class="text-muted">:{{ $server->port }}</span></td>
                <td class="map">N/A</td>
                <td class="players">N/A</td>
                <td class="weather">N/A</td>
                <td class="options">N/A</td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    <p>Last updated: 1 minute ago</p>
</div>
@endsection

@stop
