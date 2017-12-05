<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Config::class, function (Faker $faker) {
    return [
        'slug' => $faker->word,
        'contact' => ''
    ];
});
