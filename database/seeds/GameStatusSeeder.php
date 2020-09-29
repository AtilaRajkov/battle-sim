<?php

use App\GameStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameStatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // resets the table
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('game_statuses')->truncate();

    $statuses = [
      'preparing',
      'started',
      'finished'
    ];

    for($i = 0; $i < count($statuses); $i++)
    {
      $game_status = new GameStatus();
      $game_status->title = $statuses[$i];
      $game_status->save();
    }

  }
}
