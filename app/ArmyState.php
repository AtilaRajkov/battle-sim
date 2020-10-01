<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArmyState extends Model
{
  protected $table = 'army_states';

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
