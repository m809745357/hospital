<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Package::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'image' => $faker->imageUrl(200, 200),
        'body' => $faker->paragraph,
        'men_money' => $faker->randomNumber(2),
        'women_money' => $faker->randomNumber(2),
        'status' => 1,
    ];
});
