<?php

namespace YSFHQ\Commands;

use Torann\GeoIP\GeoIPFacade as GeoIP;

use YSFHQ\Commands\Command;
use Illuminate\Support\Facades\Cache;
use YSFHQ\Domains\Server;

class CheckServer extends Command
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        ob_start();
        passthru('/usr/bin/python2.7 '.base_path().'/ys_proto.py '.$this->server->ip.' '.$this->server->port);
        $output = ob_get_clean();
        $output = json_decode($output);

        if ($output->userOption==1) {
            $playerNames = 'always show player names';
        } else if ($output->userOption==2) {
            $playerNames = 'never show player names';
        } else {
            $playerNames = 'show player names within '.$output->userOption.'m';
        }

        $result = [
            'status' => ucfirst($output->status),
            'version' => $output->version,
            'map' => $output->map,
            'players' => [
                'flying' => $output->flyingUsers,
                'notflying' => intval($output->users) - intval($output->flyingUsers),
                'total' => $output->users,
            ],
            'users' => [],
            'weather' => [
                'is_day' => $output->weather[0],
                'visib' => $output->weather[5],
                'wind_x' => $output->weather[2],
                'wind_y' => $output->weather[3],
                'wind_z' => $output->weather[4],
            ],
            'options' => [
                'blackout' => $output->blackoutON,
                'collisions' => $output->collON,
                'landev' => $output->landevON,
                'missiles' => $output->missileON,
                'weapon' => $output->weaponON,
                'radar' => 'RADARALTI '.$output->radarAlti.'m | '.$playerNames,
                'f3' => $output->f3view,
            ],
        ];

        foreach ($output->userList as $i => $user) {
            if ($user[4]!='serverlist_bot') {
                $result['users'][] = [
                    'id' => $user[2],
                    'iff' => $user[1],
                    'name' => $user[4],
                    'server' => $user[0]==2 ? true : false,
                ];
            }
        }

        $result['weather']['wind_dir'] = atan2(intval($result['weather']['wind_x']), intval($result['weather']['wind_y']));
        $result['weather']['wind_speed'] = round((rad2deg(atan2(intval($result['weather']['wind_x']), intval($result['weather']['wind_y']))) + 360) % 360, 0);
        $result['weather']['weather_img'] = $this->createWeatherImg($result['weather']['visib'], $result['weather']['wind_dir']);

        $result_obj = json_decode(json_encode($result));

        Cache::put($this->server->ip.':'.$this->server->port, $result_obj, 5);

        $location = GeoIP::getLocation(gethostbyname($this->server->ip));
        $this->server->country = $location['isoCode'];
        $this->server->latitude = $location['lat'];
        $this->server->longitude = $location['lon'];
        $this->server->save();

        return $result_obj;
    }

    private function createWeatherImg($visib, $heading)
    {
        $im = imagecreatetruecolor(40, 20);

        $heading=$heading-1.570796;

        $color = (20000 - min(20000, $visib)) * 0.01274;

        $black = imagecolorallocate($im, 0, 0, 0);
        $blue  = imagecolorallocate($im, $color, $color, 255);
        $white = imagecolorallocate($im, 255, 255, 255);

        imagefilledrectangle($im, 0, 0, 40, 20, $white);
        imagefilledrectangle($im, 0, 0, 20, 20, $blue);

        imageellipse($im,30,10,19,19,$black);
        $ax = 30 + 6 * cos($heading);
        $ay = 10 + 6 * sin($heading);
        imageline($im, 30, 10, $ax, $ay, $black);

        ob_start();
        imagepng($im);
        $buffer = ob_get_clean();
        //ob_end_clean();
        $output = base64_encode($buffer);

        imagedestroy($im);

        return 'data:image/png;base64,'.$output;
    }
}
