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


    public function createWeatherImg($visib, $heading)
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
        ob_end_clean();
        $output = base64_encode($buffer);

        imagedestroy($im);

        return 'data:image/png;base64,'.$output;
    }

}
