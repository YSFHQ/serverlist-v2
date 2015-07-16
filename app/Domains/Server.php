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
}
