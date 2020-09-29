<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('armies', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('game_id');
      $table->string('name');
      $table->integer('units_number');
      $table->unsignedBigInteger('attack_strategy_id');
      $table->unsignedBigInteger('army_state_id');
      $table->timestamps();

      $table->foreign('game_id')
        ->references('id')
        ->on('games');

      $table->foreign('attack_strategy_id')
        ->references('id')
        ->on('attack_strategies');

      $table->foreign('army_state_id')
        ->references('id')
        ->on('army_states');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('armies');
  }
}
