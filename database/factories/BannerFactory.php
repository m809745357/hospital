<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Banner::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'url' => $faker->url(),
        'image' => $faker->imageUrl(1920, 611),
        'status' => 1
    ];
});
