<?php

namespace YSFHQ\Domains;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'owner', 'website', 'ip', 'port', 'country', 'latitude', 'longitude'];

    public function getStatusAttribute()
    {
        return 'online';
    }

    public function getGameAttribute()
    {
        $result = [
            'map' => 'HAWAII',
            'players' => [
                'flying' => 4,
                'notflying' => 2,
                'total' => 6,
            ],
            'weather' => [
                'is_day' => true,
                'visib' => 4000,
                'wind_x' => 1,
                'wind_y' => 4,
                'wind_z' => 3,
            ],
            'options' => [
                'blackout' => true,
                'collisions' => true,
                'landev' => false,
                'missiles' => false,
                'weapon' => false,
                'radar' => 'RADARALTI 304.80m | show player names within 4000m',
                'f3' => true,
            ],
        ];

        $result['weather']['wind_dir'] = atan2(intval($result['weather']['wind_x']), intval($result['weather']['wind_y']));
        $result['weather']['wind_speed'] = round((rad2deg(atan2(intval($result['weather']['wind_x']), intval($result['weather']['wind_y']))) + 360) % 360, 0);
        $result['weather']['weather_img'] = $this->createWeatherImg($result['weather']['visib'], $result['weather']['wind_dir']);

        return json_decode(json_encode($result));
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
