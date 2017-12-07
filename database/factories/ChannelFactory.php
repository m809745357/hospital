<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Channel::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->word,
        'describe' => $faker->word,
    ];
});
