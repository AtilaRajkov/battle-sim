<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
  protected $table = 'games';

  protected $guarded = [];

  // Tell laravel to fetch text value and set them as array:
  protected $casts = [
    'attack_order' => 'array'
  ];

  public function game_status()
  {
    return $this->belongsTo(GameStatus::class);
  }

  public function armies()
  {
    return $this->hasMany(Army::class);
  }

}
