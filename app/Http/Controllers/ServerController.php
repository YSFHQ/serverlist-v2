<?php

namespace YSFHQ\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        return redirect()->route('server.show', ['id' => $server->id])->with('success', 'Server created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            return view('pages.view-server', ['server' => Server::findOrFail($id)]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('index')->with('error', 'Server not found.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            return view('pages.add-edit-server', ['server' => Server::findOrFail($id)]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('index')->with('error', 'Server not found.');
        }
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
            return redirect()->route('server.show', ['id' => $id])->with('success', 'Server updated.');
        }
        return back()->withInput()->with('error', 'Could not update server.');
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
            return redirect()->route('index')->with('success', 'Server deleted.');
        }
        return redirect()->route('index')->with('error', 'Could not delete server.');
    }
}
