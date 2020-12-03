<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;


    protected $attributes = [

    ];

    protected $casts=[ "pro"=>'array' ];

    public function comments()
    {
        return $this->hasMany('App\comment');
    }

    public function img()
    {
        return $this->hasMany('App\imgCollection');
    }

}
