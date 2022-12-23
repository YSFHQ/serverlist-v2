<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{
    Bus,
    Cache,
    Log
};

use App\Commands\CheckServer;
use App\Commands\UpdateMaps;

class Server extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'owner', 'website', 'ip', 'port', 'country', 'latitude', 'longitude', 'last_online'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_online' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status', 'game'];

    public function distance($location, $unit = "M") {
        $lat1 = $this->latitude;
        $lon1 = $this->longitude;
        $lat2 = $location['lat'];
        $lon2 = $location['lon'];

        try {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
        } catch (\Exception $e) {
            return -1;
        }

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function lastupdated()
    {
        return $this->updated_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return Cache::get($this->ip.':'.$this->port)->status;
    }

    public function getGameAttribute()
    {
        return Cache::get($this->ip.':'.$this->port);
    }

    public function checkServer()
    {
        return Bus::dispatch(
            new CheckServer($this)
        );
    }

    public function mapLink()
    {
        $map = $this->game->map;

        if (!Cache::has('map_links')) {
            try {
                Bus::dispatch(
                    new UpdateMaps()
                );
            } catch (\Exception $e) {
                Log::error($e);
            }
        }

        $maps = Cache::get('map_links', []);

        $maps_found = array_filter($maps, function ($var) use ($map) {
            return $var['mapname']==$map;
        });

        if (count($maps_found)) return reset($maps_found);

        return null;
    }

}
