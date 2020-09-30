<?php

namespace App\Http\Controllers\Api;

use App\Game;
use App\GameStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{

  public function create_game()
  {

    $started_status_id = GameStatus::where('title', 'started')->first()->id;
    $started_games = Game::where('game_status_id', $started_status_id)->get();

    // Checking how many games are already in progress
    if (count($started_games) == 5) {

      $error = [
        'error' => 'Sorry, there are already 5 games in progress.'
      ];

      return response()->json(['data' => $error]);
    }

    // Creating a new game
    $new_game = new Game();
    $new_game->game_status_id = $started_status_id;
    $new_game->save();

    $data = [
      'game_id' => $new_game->id
    ];

    return response()->json(['data' => $data], 201);
  }

}
