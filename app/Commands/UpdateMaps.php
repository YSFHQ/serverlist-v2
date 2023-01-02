<?php

namespace App\Commands;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class UpdateMaps
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
        $doc = json_decode(file_get_contents('https://sheets.googleapis.com/v4/spreadsheets/1-yNrS0cw9VQ6Ut6hHnbOlAA_aJNqRPPpaA3B3rwzbWk/values/Sheet1?key='.env('GOOGLE_SHEETS_KEY')), true);
        $rows = $doc["values"];
        array_shift($rows); // remove headers

        $maps = [];

        foreach ($rows as $row) {
            $maps[] = ['mapname' => $row[0], '', 'packname' => $row[1], 'downloadlink' => $row[2]];
        }

        Cache::put('map_links', $maps, Carbon::now()->addHours(6));
    }
}
