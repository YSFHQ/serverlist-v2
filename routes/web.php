<?php

if (starts_with(env('APP_URL'), 'https://')) {
    URL::forceSchema('https');
}

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('server', 'ServerController');

Route::get('/', ['uses' => 'ServerController@index', 'as' => 'index']);
Route::get('/map', ['uses' => 'StaticController@map', 'as' => 'map']);
Route::get('/stats', ['uses' => 'StaticController@stats', 'as' => 'stats']);
Route::get('/log', ['uses' => 'StaticController@log', 'as' => 'log']);
Route::get('/help', ['uses' => 'StaticController@help', 'as' => 'help']);