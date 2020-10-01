<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttackStrategy extends Model
{
  protected $table = 'attack_strategies';

  protected $fillable = ['title'];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public function armies()
  {
    return $this->hasMany(Army::class);
  }
}
