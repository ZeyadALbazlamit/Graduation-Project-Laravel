<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\category;
use Faker\Generator as Faker;

$factory->define(category::class, function (Faker $faker) {
    return [

       'name' => $faker->name,
             "img"=>'https://www.google.com/imgres?imgurl=http%3A%2F%2Fpatriziawish.com%2Fwp-content%2Fuploads%2F2019%2F06%2F1561682347.jpg&imgrefurl=http%3A%2F%2Fpatriziawish.com%2F10-future-concept-cars-you-must-see%2F&tbnid=WT8c5cqtQ8TNsM&vet=12ahUKEwi3qMKg16_sAhVCpBoKHZHPA2wQMygRegUIARDIAQ..i&docid=QiNBZExIX6ERrM&w=1280&h=720&q=car&ved=2ahUKEwi3qMKg16_sAhVCpBoKHZHPA2wQMygRegUIARDIAQ',
    ];
});
