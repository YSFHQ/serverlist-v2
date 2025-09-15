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
        $cacheKey = $this->ip.':'.$this->port;
        $cachedData = Cache::get($cacheKey);

        if ($cachedData && isset($cachedData->status)) {
            return $cachedData->status;
        }

        return 'offline';
    }

    public function getGameAttribute()
    {
        $cacheKey = $this->ip.':'.$this->port;
        $cachedData = Cache::get($cacheKey);

        if ($cachedData) {
            return $cachedData;
        }

        // Return a default game object when cache is empty
        return (object) [
            'status' => 'offline',
            'map' => 'Unknown',
            'users' => 0,
            'flyingUsers' => 0,
            'missileON' => false,
            'weaponON' => false,
            'blackoutON' => false,
            'collON' => false,
            'landevON' => false,
            'weather' => [0, 0, 0.0, 0.0, 0.0, 0.0],
            'userOption' => 0,
            'radarAlti' => '',
            'f3view' => true,
            'userList' => []
        ];
    }

    public function checkServer()
    {
        return Bus::dispatch(
            new CheckServer($this)
        );
    }

    public function mapLink()
    {
        if (!isset($this->game->map) || empty($this->game->map)) {
            return null;
        }

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

        if (!is_array($maps)) {
            return null;
        }

        $maps_found = array_filter($maps, function ($var) use ($map) {
            return isset($var['mapname']) && $var['mapname'] == $map;
        });

        if (count($maps_found)) return reset($maps_found);

        return null;
    }

}
