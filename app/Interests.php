<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interests extends Model
{
  public function categories()
    {
      return $this->hasMany('App\category');
    }

}
