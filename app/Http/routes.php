<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('pages/home');
});
Route::get('/map', function () {
    return view('pages/map');
});
Route::get('/stats', function () {
    return view('pages/stats');
});
Route::get('/log', function () {
    return view('pages/log');
});
Route::get('/help', function () {
    return view('pages/help');
});
