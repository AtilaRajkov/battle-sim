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
