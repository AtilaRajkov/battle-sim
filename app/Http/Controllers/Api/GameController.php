<?php

namespace App\Http\Controllers\Api;

use App\ArmyState;
use App\AttackStrategy;
use App\Game;
use App\GameStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class GameController extends Controller
{

  public function lobby()
  {
    $games = Game::all();
    return view('game.lobby', compact('games'));
  }


  public function list_games($game_id = NULL)
  {
    if ($game_id != NULL) {
      $games = Game::where('id', $game_id)
        ->with('game_status')
        ->with('armies.attack_strategy')
        ->with('armies.army_state')
        ->first();

      return $games;
    } else {
      $games = Game::with('game_status')
        ->with('armies.attack_strategy')
        ->with('armies.army_state')
        ->get();
    }



    return response()->json(['data' => $games]);
  }


  public function create_game()
  {

    $preparing_status_id = GameStatus::where('title', 'preparing')->first()->id;

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
    $new_game->game_status_id = $preparing_status_id;
    $new_game->save();

    $data = [
      'game_id' => $new_game->id
    ];

//    return $data;
    return response()->json(['data' => $data], 201);
  }



  public function run_attack(Game $game)
  {
    // If the battle is already finished return a message:
    if ($game->game_status->title == 'finished') {
      $data = [
        'game' => $this->list_games($game->id),
        'message' => 'This battle is finished.'
      ];
      return $data;
    }

    // Checking if there is enough armies for the battle:
    if ($game->armies->count() < 3) {
      $data = [
        'error' => 'There needs to be at least 5 armies to begin the battle.'
      ];
      return $data;
    }

    // There are at least 5 armies, the battle can begin!

    // Setting the game status to started if it is not already set:
    $game_status = $game->game_status->title;
    if ($game_status == 'preparing') {
      $game->update([
        'game_status_id' => GameStatus::where('title', 'started')->first()->id
      ]);
    }


    $attack_order = $game->attack_order;

    foreach($attack_order as $army_id) {

      $attacking_army = $game->armies()->where('id', $army_id)->first();

      $strategy = $attacking_army->attack_strategy->title;

//      $potential_targets = $game->armies() ->where('id', '<>', $army_id)->get()->pluck( 'units_number', 'id');

      $potential_targets = $game->armies()
        ->where('id', '<>', $army_id)
        ->where('units_number', '<>', 0)
        ->get();

      // Picking the targeted army based on the strategy of the attacking army:
      if (count($potential_targets) == 1) {
        $targeted_army = $potential_targets->first();
      } else {
        if ($strategy == 'weakest') {

          $targeted_army = $game->armies()
            ->where('units_number',
              $potential_targets->min('units_number'))
            ->get()
            ->random();

        } else if ($strategy == 'strongest') {
          $targeted_army = $game->armies()
            ->where('units_number', '<>', 0)
            ->where('units_number',
              $potential_targets->max('units_number'))
            ->get()
            ->random();

        } else if ($strategy == 'random') {
          $targeted_army = $potential_targets
            ->random();
        }
      }

      // Calculating the Attack chance:
      if (rand(1, 100) <= $attacking_army->units_number) {
        $hit = true;
      } else {
        $hit = false;
      }

      if ($hit) {
        // Calculating the attacking army damage:
        $damage = intval(floor($attacking_army->units_number * 0.5));

        $units_left = $targeted_army->units_number - $damage;

        if ($units_left <= 0) {

          $units_left = 0;

          $targeted_army->update([
            'units_number' => $units_left,
            'army_state_id' => ArmyState::where('title', 'defeated')
                                      ->first()->id
          ]);

          // Updating the attack_order of the battle:
          //$new_attack_order = array_diff($attack_order, [$targeted_army->id]);
          foreach ($attack_order as $key => $value) {
              if ($value == $targeted_army->id) {
                unset($attack_order[$key]);
              }
          }

          $new_attack_order = array_values($attack_order);

          $game->update([
            'attack_order' => $new_attack_order
          ]);


        } else {
          $targeted_army->update([
            'units_number' => $units_left
          ]);
        }

        // Declaring the winner adn finishing the battle (game):
        if (count($attack_order) == 1) {
          $attacking_army->update([
            'army_state_id' => ArmyState::where('title', 'winner!')->first()->id
          ]);

          $game->update([
            'game_status_id' => GameStatus::where('title', 'finished') ->first()->id
          ]);


        }


      }


    }

    // Update the turn:
    $game->update([
      'turn' => ++$game->turn
    ]);

    $game = $this->list_games($game->id);

//    return response()->json(['game' => $game]);

//    $game =  (string) $game;
//    $game = new JsonResponse($game);

    return [
      'game' => $game,
      'turn' => $game->turn
    ];
  }


}
