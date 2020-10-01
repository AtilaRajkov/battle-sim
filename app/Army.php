<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Army extends Model
{
  protected $table = 'armies';

  protected $guarded = [];


  protected $hidden = [
    'game_id',
    'attack_strategy_id',
    'army_state_id'
  ];


  public function game()
  {
    return $this->belongsTo(Game::class);
  }

  public function attack_strategy()
  {
    return $this->belongsTo(AttackStrategy::class);
  }

  public function army_state()
  {
    return $this->belongsTo(ArmyState::class);
  }
}
