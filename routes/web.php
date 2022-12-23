<?php

use App\Http\Controllers\ServerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

if (str_starts_with(env('APP_URL'), 'https://')) {
    URL::forceScheme('https');
}

Route::resource('server', ServerController::class);

Route::controller(ServerController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/map', 'map')->name('map');
    Route::get('/stats', 'stats')->name('stats');
    Route::get('/log', 'log')->name('log');
    Route::get('/help', 'help')->name('help');
});
