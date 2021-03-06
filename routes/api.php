<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// **Create a Game**
Route::get('/create-game', 'Api\GameController@create_game')
  ->name('create.game');

// **Add army**
Route::post('/add-army', 'Api\ArmyController@add_army')
  ->name('add.army');

// **List games**
Route::get('/list-games', 'Api\GameController@list_games')
  ->name('list.games');

// **Run attack**
Route::post('/run-attack/{game}', 'Api\GameController@run_attack')
  ->name('run-attack');

// ** Autorun **
Route::post('/autorun/{game}', 'Api\GameController@autorun')
  ->name('autorun');
