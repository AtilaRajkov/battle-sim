<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // $this->call(UsersTableSeeder::class);
    $this->call(GameStatusSeeder::class);
    $this->call(AttackStrategySeeder::class);
    $this->call(ArmyStateSeeder::class);

  }
}
