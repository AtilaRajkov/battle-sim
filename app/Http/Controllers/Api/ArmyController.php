<?php

namespace App\Http\Controllers\Api;

use App\Army;
use App\ArmyState;
use App\AttackStrategy;
use App\Game;
use App\GameStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArmyController extends Controller
{

  public function create(Game $game)
  {
    $game_id = $game->id;

    $strategies = AttackStrategy::all();

    $armies = $game->armies;

    return view('army.front', compact('game', 'game_id','strategies', 'armies'));
  }


  public function add_army()
  {
    $errors = [];

    if (empty(request()->name)) {
      $errors['name'] = 'Army name field is required';
    }

    if (
      empty(request()->units) ||
      !is_numeric(request()->units) ||
      request()->units < 80 ||
      request()->units > 100
    ) {
      $errors['units'] = 'You can enter 80 to 100 units';
    }

    $strategy_array = AttackStrategy::all()->pluck('id')->toArray();
    if (
      empty(request()->attack_strategy_id) ||
      !in_array(request()->attack_strategy_id, $strategy_array)
    ) {
      $errors['attack_strategy_id'] = 'You did not enter a valid attack strategy';
    }

    $data = [
      'errors' => $errors,
      'army' => ''
    ];

    // Return errors:
    if (count($data['errors']) > 0) {
      return $data;
    }

    // There are no errors: //

    // Creating a new army:
    $army = new Army();
    $army->game_id = request('game_id');
    $army->name = request('name');
    $army->units_number = request('units');
    $army->attack_strategy_id = request( 'attack_strategy_id');
    $army->army_state_id  = ArmyState::where('title', 'fighting')->first()->id;
    $army->save();


    // Setting the attack_order in the games table
    $game = Game::where('id', request()->game_id)->first();
    $attack_order_array = $game->attack_order;

    // If the game is already started the army id needs to be inserted in the beginning of the attack order:
    $game_status_id = $game->game_status_id;

    $game_started_id = GameStatus::where('title', 'started')->first()->id;

    if ($game_status_id === $game_started_id) {

      array_unshift($attack_order_array, $army->id);

      $game->update([
        'attack_order' => $attack_order_array
      ]);

    } else if (is_null($game->attack_order)) {
      // If this is the first army of this game we need to create an array:
      $game->update([
        'attack_order' => [$army->id]
      ]);
    } else {
      // If it is not the first army we just need to add the new army id to the array:
      $attack_order_array[] = $army->id;

      $game->update([
        'attack_order' => $attack_order_array
      ]);

    }

    $data['army'] = $army;
    $army_state = $army->army_state->title;
    $data['army']['army_state'] = $army_state;

    return $data;

  }

}
