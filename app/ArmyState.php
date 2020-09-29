<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArmyState extends Model
{
  protected $table = 'army_states';

  protected $fillable = ['title'];

  public function armies()
  {
    return $this->hasMany(Army::class)
      ->withTimestamps();
  }
}
