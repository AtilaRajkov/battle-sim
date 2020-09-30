<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttackStrategy extends Model
{
  protected $table = 'attack_strategies';

  protected $fillable = ['title'];

  public function armies()
  {
    return $this->hasMany(Army::class);
  }
}
