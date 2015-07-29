<?php

namespace YSFHQ\Commands;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

use YSFHQ\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateMaps extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $doc = json_decode(file_get_contents('https://spreadsheets.google.com/feeds/list/1-yNrS0cw9VQ6Ut6hHnbOlAA_aJNqRPPpaA3B3rwzbWk/od6/public/values?alt=json'), true);
        $rows = $doc['feed']['entry'];

        $maps = [];

        foreach ($rows as $row) {
            $maps[] = ['mapname' => $row['gsx$mapname']['$t'], '', 'packname' => $row['gsx$packname']['$t'], 'downloadlink' => $row['gsx$downloadlink']['$t']];
        }

        Cache::put('map_links', $maps, Carbon::now()->addHours(6));
    }
}
