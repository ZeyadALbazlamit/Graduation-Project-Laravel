<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use SoftDeletes;

    public function posts()
    {
        return $this->hasMany('App\post');
    }





}
