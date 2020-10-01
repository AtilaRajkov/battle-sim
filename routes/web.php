<?php

use Illuminate\Support\Facades\Route;

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

// The Game Lobby: //
Route::get('/', 'Api\GameController@lobby');

Route::get('/game/{game}/front', 'Api\ArmyController@create')
  ->name('army.create');
