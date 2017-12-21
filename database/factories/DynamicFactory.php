<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Dynamic::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'desc' => $faker->paragraph,
        'body' => $faker->paragraph,
        'image' => $faker->imageUrl(200, 200),
        'status' => 1,
        'click_num' => rand(100, 200),
    ];
});
