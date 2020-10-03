<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('games', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('turn')->default(1);
      $table->unsignedBigInteger('game_status_id');
      $table->json('attack_order')->nullable();
      $table->timestamps();

      $table->foreign('game_status_id')
        ->references('id')
        ->on('game_statuses');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('games');
  }
}
