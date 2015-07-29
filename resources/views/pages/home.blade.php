@extends('app')

@section('title') Home - @parent @stop
@section('content')
<div class="row">
    <h3>Servers</h3>

    <div class="checkbox">
        <label>
            <input type="checkbox" id="toggleMap"> Map
        </label>
        <label>
            <input type="checkbox" id="togglePlayers"> Players
        </label>
        <label>
            <input type="checkbox" id="toggleWeather"> Weather
        </label>
        <label>
            <input type="checkbox" id="toggleOptions"> Options
        </label>
        <label>
            <input type="checkbox" id="toggleOffline"> <span class="text-danger">Offline</span>
        </label>
    </div>

    <div class="table-responsive">
    <table class="table table-hover" id="server-list">
        <thead>
            <tr>
                <th class="join"></th>
                <th class="name">Server Name</th>
                <th class="ip">IP(:port)</th>
                <th class="map">Map</th>
                <th class="players">Players</th>
                <th class="weather">Weather</th>
                <th class="options">Options</th>
                <th class="clock"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($servers as $server)
            <tr class="{{ $server->status == 'Online' ? 'success' : 'danger' }}">
                <td class="join">
                @if ($server->status == 'Online')
                    <a href="ysflight://{{ $server->ip }}"><img src="img/ys2.png" title="click to connect this server"></a>
                    Ver. {{ $server->game->version }}
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
                    <?php
                    $maplink = $server->mapLink();
                    ?>
                    @if ($maplink)
                    <a href="{{ $maplink['downloadlink'] }}" title="From pack: {{ $maplink['packname'] }}" target="_blank">{{ $server->game->map }}</a>
                    @else
                    {{ $server->game->map }}
                    @endif
                @else
                    N/A
                @endif
                </td>
                <td class="players">
                @if ($server->status == 'Online')
                    <?php $maxplayers = 10; ?>
                    <div class="progress">
                        <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="{{ $server->game->players->notflying }}" aria-valuemin="0" aria-valuemax="{{ $maxplayers }}" style="width: {{ min($server->game->players->notflying/$maxplayers, 1) * 100 }}%;">
                            {{ $server->game->players->notflying }}
                        </div>
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ $server->game->players->flying }}" aria-valuemin="0" aria-valuemax="{{ $maxplayers }}" style="width: {{ min($server->game->players->flying/$maxplayers, 1) * 100 }}%;">
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
