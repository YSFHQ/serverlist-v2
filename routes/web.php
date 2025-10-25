<?php

use App\Http\Controllers\ServerController;
use App\Http\Controllers\StaticController;
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

Route::get('/', [ServerController::class, 'index'])->name('index');
