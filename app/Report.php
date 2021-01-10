<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    public function post(){
        return $this->hasMany('App\Post');
    }
}
