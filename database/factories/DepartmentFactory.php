<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->word
    ];
});
