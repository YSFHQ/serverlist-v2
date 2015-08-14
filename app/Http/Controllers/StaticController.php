<?php

namespace YSFHQ\Http\Controllers;

use Illuminate\Http\Request;

use YSFHQ\Http\Requests;
use YSFHQ\Http\Controllers\Controller;

class StaticController extends Controller
{

    /**
     * Display a map of all the servers.
     *
     * @return Response
     */
    public function map()
    {
        return view('pages/map');
    }

    /**
     * Display server statistics.
     *
     * @return Response
     */
    public function stats()
    {
        return view('pages/stats');
    }

    /**
     * Display a log of actions performed on the server list.
     *
     * @return Response
     */
    public function log()
    {
        return view('pages/log');
    }

    /**
     * Display the help documents.
     *
     * @return Response
     */
    public function help()
    {
        return view('pages/help');
    }

    /**
     * Display the chat.
     *
     * @return Response
     */
    public function chat()
    {
        return view('pages/chat');
    }

}
