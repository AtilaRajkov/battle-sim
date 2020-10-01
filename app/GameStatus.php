<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameStatus extends Model
{
  protected $table = 'game_statuses';

  protected $fillable = ['title'];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public function games()
  {
    return $this->hasMany(Game::class);
  }
}
