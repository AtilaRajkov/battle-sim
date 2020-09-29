<?php

use App\AttackStrategy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttackStrategySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // resets teh table
    //DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('attack_strategies')->truncate();

    $strategies = [
      'random',
      'weakest',
      'strongest'
    ];

    for($i = 0; $i < count($strategies); $i++)
    {
      $attack_strategy = new AttackStrategy();
      $attack_strategy->title = $strategies[$i];
      $attack_strategy->save();
    }

  }
}
