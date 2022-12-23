@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col col-md-8">
        <h3>YSFlight Multiplayer Servers</h3>

        <p>
            <strong>Welcome to the server list!</strong> Click the checkboxes below to toggle the columns shown.
            Hover over the server name to see which version of YSFlight it is using, and click it for more info about the server.
            Visit <a href="http://forum.ysfhq.com/" target="_blank">YSFlight Headquarters</a> if you need help or want to join the largest YSFlight community.
            <em>Enjoy flying online!</em>
        </p>

        <div class="checkbox">
            <label>
                <input type="checkbox" id="toggleMap" checked> Map
            </label>
            <label>
                <input type="checkbox" id="togglePlayers" checked> Players
            </label>
            <label>
                <input type="checkbox" id="toggleWeather" checked> Weather
            </label>
            <label>
                <input type="checkbox" id="toggleOptions" checked> Options
            </label>
            <label>
                <input type="checkbox" id="toggleOffline" checked> <span class="text-danger">Offline</span>
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
                        {{-- <th class="clock"></th> --}}
                    </tr>
                </thead>
                <tbody>
                @foreach ($servers as $server)
                    <tr class="{{ $server->status == 'Online' ? 'table-success' : 'table-danger' }}">
                        <td class="join">
                        @if ($server->status == 'Online')
                            <a href="ysflight://{{ $server->ip }}"><img src="{{ Vite::asset('resources/images/ys2.png') }}" title="click to connect this server"></a>
                        @else
                            Offline
                        @endif
                        </td>
                        <td class="name">
                            <a href="{{ route('map', ['server' => $server->id]) }}"><img src="{{ Vite::asset('resources/images/flags/'.strtolower($server->country).'.gif') }}" title="{{ strtoupper($server->country) }} - Distance to the server: {{ round($server->distance($location), 1) }}mi"></a>
                            <a href="{{ route('server.show', ['server' => $server->id]) }}" title="owner: {{ $server->owner }} | YS version: {{ $server->status == 'Online' ? $server->game->version : 'N/A' }}">{{ $server->name }}</a>
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
                            @if ($server->game->players->total > 0)
                                <strong><span class="text-danger">{{ $server->game->players->flying }}</span></strong> / <span class="text-primary">{{ $server->game->players->total }}</span> <strong><span class="text-danger">flying</span></strong>
                            @else
                                <span class="text-muted">Empty</span>
                            @endif
                            <?php $maxplayers = 10; ?>
                            <!-- <div class="progress">
                                <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="{{ $server->game->players->notflying }}" aria-valuemin="0" aria-valuemax="{{ $maxplayers }}" style="width: {{ min($server->game->players->notflying/$maxplayers, 1) * 100 }}%;">
                                    {{ $server->game->players->notflying }}
                                </div>
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ $server->game->players->flying }}" aria-valuemin="0" aria-valuemax="{{ $maxplayers }}" style="width: {{ min($server->game->players->flying/$maxplayers, 1) * 100 }}%;">
                                    {{ $server->game->players->flying }}
                                </div>
                            </div> -->
                        @else
                            N/A
                        @endif
                        </td>
                        <td class="weather">
                        @if ($server->status == 'Online')
                            <img src="{{ Vite::asset('resources/images/'.($server->game->weather->is_day ? 'day' : 'night').'.png') }}" title="{{ $server->game->weather->is_day ? 'day' : 'night' }}">
                            <img src="{{ $server->game->weather->weather_img }}" title="visibility: {{ $server->game->weather->visib }}m | wind direction: {{ $server->game->weather->wind_dir }} | wind speed: {{ $server->game->weather->wind_speed }}m/s | windx={{ $server->game->weather->wind_x }} | windy={{ $server->game->weather->wind_x }} | windz={{ $server->game->weather->wind_z }}" />
                        @else
                            N/A
                        @endif
                        </td>
                        <td class="options">
                        @if ($server->status == 'Online')
                            <img src="{{ Vite::asset('resources/images/blackout_'.($server->game->options->blackout ? 'on' : 'off').'.png') }}" title="blackout {{ $server->game->options->blackout ? 'on' : 'off' }}">
                            <img src="{{ Vite::asset('resources/images/collisions_'.($server->game->options->collisions ? 'on' : 'off').'.png') }}" title="collisions {{ $server->game->options->collisions ? 'on' : 'off' }}">
                            <img src="{{ Vite::asset('resources/images/landev_'.($server->game->options->landev ? 'on' : 'off').'.png') }}" title="land everywhere {{ $server->game->options->landev ? 'on' : 'off' }}">
                            <img src="{{ Vite::asset('resources/images/missiles_'.($server->game->options->missiles ? 'on' : 'off').'.png') }}" title="missiles {{ $server->game->options->missiles ? 'on' : 'off' }}">
                            <img src="{{ Vite::asset('resources/images/weapon_'.($server->game->options->weapon ? 'on' : 'off').'.png') }}" title="weapons {{ $server->game->options->weapon ? 'on' : 'off' }}">
                            <img src="{{ Vite::asset('resources/images/radar.png') }}" title="{{ $server->game->options->radar }}">
                            <img src="{{ Vite::asset('resources/images/f3_'.($server->game->options->f3 ? 'on' : 'off').'.png') }}" title="F3 view {{ $server->game->options->f3 ? 'on' : 'off' }}">
                        @else
                            N/A
                        @endif
                        </td>
                        {{-- <td class="clock">
                            <img src="{{ Vite::asset('resources/images/clock.png') }}" title="information updated: {{ $server->lastupdated() }}">
                        </td> --}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <div class="col">
        <h4>YSFHQ Discord</h4>
        <iframe src="https://discord.com/widget?id=199291260417081344&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
    </div>

</div>
@endsection
