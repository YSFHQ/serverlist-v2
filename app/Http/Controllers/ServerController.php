<?php

namespace YSFHQ\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

use Torann\GeoIP\GeoIPFacade as GeoIP;

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
    public function index(Request $request)
    {
        foreach (Server::all() as $server) {
            if (!Cache::has($server->ip.':'.$server->port)) {
                $server->checkServer();
            }
        }
        return view('pages.home', [
            'servers' => Server::all(),
            'location' => GeoIP::getLocation(gethostbyname($request->ip()))
        ]);
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
        $input = $request->except('_token');
        $location = GeoIP::getLocation(gethostbyname($input['ip']));
        if (!$location['default']) {
            $input['country'] = $location['isoCode'];
            $input['latitude'] = $location['lat'];
            $input['longitude'] = $location['lon'];
        }
        $server = Server::firstOrCreate($input);
        $server->checkServer();
        return redirect()->route('server.show', ['id' => $server->id])->with('success', 'Server created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
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
    public function edit(Request $request, $id)
    {
        try {
            $server = Server::findOrFail($id);
            if (gethostbyname($server->ip)==$request->ip()) {
                return view('pages.add-edit-server', ['server' => $server]);
            }
            return redirect()->route('index')->with('error', 'You do not have proper permissions to edit the server.');
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
        $server = Server::findOrFail($id);
        if (gethostbyname($server->ip)==$request->ip()) {
            $input = $request->except('_token');
            $location = GeoIP::getLocation(gethostbyname($input['ip']));
            if (!$location['default']) {
                $input['country'] = $location['isoCode'];
                $input['latitude'] = $location['lat'];
                $input['longitude'] = $location['lon'];
            }
            if ($server->update($input)) {
                return redirect()->route('server.show', ['id' => $id])->with('success', 'Server updated.');
            }
            return back()->withInput()->with('error', 'Could not update server.');
        }
        return back()->withInput()->with('error', 'You do not have proper permissions to update the server.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $server = Server::findOrFail($id);
        if (gethostbyname($server->ip)==$request->ip()) {
            if ($server->delete()) {
                return redirect()->route('index')->with('success', 'Server deleted.');
            }
            return redirect()->route('index')->with('error', 'Could not delete server.');
        }
        return redirect()->route('index')->with('error', 'You do not have proper permissions to delete the server.');
    }
}
