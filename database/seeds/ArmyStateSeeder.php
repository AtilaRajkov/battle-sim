<?php

use App\ArmyState;
use Illuminate\Database\Seeder;

class ArmyStateSeeder extends Seeder
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
    DB::table('army_states')->truncate();

    $states = [
      'fighting',
      'defeated',
      'winner'
    ];

    for($i = 0; $i < count($states); $i++)
    {
      $state = new ArmyState();
      $state->title = $states[$i];
      $state->save();
    }
  }
}
