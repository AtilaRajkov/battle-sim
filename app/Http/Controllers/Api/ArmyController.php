<?php

namespace App\Http\Controllers\Api;

use App\Army;
use App\ArmyState;
use App\AttackStrategy;
use App\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArmyController extends Controller
{

  public function create(Game $game)
  {
    $game_id = $game->id;

    $strategies = AttackStrategy::all();

    return view('army.front', compact('game_id','strategies'));
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
      'test' => ''
    ];

    // Return errors
    if (count($data['errors']) > 0) {
      return $data;
    }

    // There no errors:
    $army = new Army();
    $army->game_id = request('game_id');
    $army->name = request('name');
    $army->units_number = request('units');
    $army->attack_strategy_id = request('attack_strategy_id');
    $army->army_state_id 	 = ArmyState::where('title', 'fighting')->first()->id;
    $army->save();

    $data['army'] = $army;

    return $data;


  }

}
