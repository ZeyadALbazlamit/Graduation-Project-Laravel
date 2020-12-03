<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\comment;
use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(comment::class, function (Faker $faker) {
    return [
        'post_id'=>$faker->NumberBetween(1,7),
        'user_id'=>factory(User::class),
        'body'=> $faker->text
    ];
});
