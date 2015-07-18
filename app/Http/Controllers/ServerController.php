<?php

namespace YSFHQ\Http\Controllers;

use Illuminate\Http\Request;

use YSFHQ\Http\Requests;
use YSFHQ\Http\Controllers\Controller;
use YSFHQ\Domains\Server;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('pages.home', ['servers' => Server::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.add-edit-server');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // we should check if the server is online before we save it
        $server = Server::firstOrCreate($request->except('_token'));
        return view('pages.view-server', ['server' => $server]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('pages.view-server', ['server' => Server::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('pages.add-edit-server', ['server' => Server::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if (Server::find($id)->update($request->except('_token'))) {
            // redirect to the show view with success flash
        }
        return back()->withInput();
        // redirect back with error flash
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if (Server::find($id)->delete()) {
            // redirect to index with success
        }
        return back()->withInput();
        // redirect to index with flash error message
    }
}
