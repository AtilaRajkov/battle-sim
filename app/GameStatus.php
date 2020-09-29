<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameStatus extends Model
{
  protected $table = 'game_statuses';

  protected $fillable = ['title'];

  public function games()
  {
    return $this->hasMany(Game::class);
  }
}
