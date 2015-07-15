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
            <tr class="success">
                <td class="join">
                    <a href="ysflight://civav.ddns.net"><img src="img/ys2.png" title="click to connect this server"></a>
                </td>
                <td class="name">
                    <a href="/map?server=1"><img src="img/flags/us.gif" title="US - Distance to the server: 9878km"></a>
                    <a href="/server/1" title="owner: Patrick31337 | YS version: 20110207">Civil Aviation Server</a>
                </td>
                <td class="ip">civav.ddns.net<span class="text-muted">:7915</span></td>
                <td class="map"><a href="http://marcjeanmougin.free.fr/ys_servers/index.php?page=mapToLink.php&amp;map=VFA-49_Homebase">Guam_to_SoCal</a></td>
                <td class="players">
                    <div class="progress">
                        <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                            6
                        </div>
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                            2
                        </div>
                    </div>
                </td>
                <td class="weather">
                    <img src="img/day.png" title="day">
                    <img src="http://ysflight.org/serverlist/weather.php?visib=20000&amp;heading=0" title="visibility: 20000m | wind direction: 0 | wind speed: 0m/s | windx=0 | windy=0 | windz=0" />
                </td>
                <td class="options">
                    <img src="img/blackout_off.png" title="blackout_off">
                    <img src="img/collisions_off.png" title="collisions_off">
                    <img src="img/landev_on.png" title="landev_on">
                    <img src="img/missiles_on.png" title="missiles_on">
                    <img src="img/weapon_on.png" title="weapon_on">
                    <img src="img/radar.png" title="RADARALTI 304.80m | show player names within 4000m">
                    <img src="img/f3_on.png" title="">
                </td>
            </tr>
            <tr class="danger">
                <td></td>
                <td>
                    <a href="/map?server=1"><img src="img/flags/ca.gif" title="CA - Distance to the server: 9878km"></a>
                    The Fight Server
                </td>
                <td>civav.ddns.net<span class="text-muted">:7915</span></td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
            </tr>
        </tbody>
    </table>
    <p>Last updated: 1 minute ago</p>
</div>
@endsection

@stop
