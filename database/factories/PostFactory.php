<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'category_id'=>factory(App\category::class),
        'user_id' => factory(App\User::class),
        'Description' => $faker->paragraph,
        'location'=> $faker->city,
        'Price'=>$faker->randomNumber(3),
        'pro'=> '{"color":35,"size":large,"Joe":43}'
        //'Category_id' => factory(App\Category::class),


    ];
});
