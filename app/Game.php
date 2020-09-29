<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
  protected $table = 'games';

  protected $guarded = [];

  public function game_status()
  {
    return $this->belongsTo(GameStatus::class)
      ->withTimestamps();
  }

  public function armies()
  {
    return $this->hasMany(Army::class)
      ->withTimestamps();
  }

}
