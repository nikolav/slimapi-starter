<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
  protected $connection = 'default';
  protected $table      = 'main';

  // Fields that can be mass-assigned
  protected $fillable = [
     'key',
     'data',
  ];

  // cast JSON to array
  protected $casts = [
     'data' => 'array',
  ];
}
