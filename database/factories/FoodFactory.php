<?php

use Faker\Generator as Faker;
use App\Models\Food;

$factory->define(Food::class, function (Faker $faker) {
    $type = Food::TYPES;

    return [
        'channel_id' => function () {
            return factory('App\Models\Channel')->create()->id;
        },
        'title' => $faker->sentence,
        'image' => $faker->imageUrl(200, 200),
        'desc' => $faker->paragraph,
        'money' => $faker->randomNumber(2),
        'type' => $type[rand(0, 2)],
        'status' => 1,
    ];
});
