<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class StaticController extends Controller
{

    /**
     * Display a map of all the servers.
     *
     * @return Response
     */
    public function map()
    {
        return view('map', ['title' => 'Map']);
    }

    /**
     * Display server statistics.
     *
     * @return Response
     */
    public function stats()
    {
        return view('stats', ['title' => 'Stats']);
    }

    /**
     * Display a log of actions performed on the server list.
     *
     * @return Response
     */
    public function log()
    {
        return view('log', ['title' => 'Log']);
    }

    /**
     * Display the help documents.
     *
     * @return Response
     */
    public function help()
    {
        return view('help', ['title' => 'Help']);
    }

}
