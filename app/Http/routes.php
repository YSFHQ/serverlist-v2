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

Route::resource('server', 'ServerController');

Route::get('/', ['uses' => 'ServerController@index', 'as' => 'index']);
Route::get('/map', ['uses' => 'StaticController@map', 'as' => 'map']);
Route::get('/stats', ['uses' => 'StaticController@stats', 'as' => 'stats']);
Route::get('/log', ['uses' => 'StaticController@log', 'as' => 'log']);
Route::get('/help', ['uses' => 'StaticController@help', 'as' => 'help']);
