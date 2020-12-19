<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $attributes = [
        "location"=>"Amman",
        "rate"=>0
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
    public function favorite()
    {
        return $this->hasMany('App\Favorite');
    }

    ///////////////
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
