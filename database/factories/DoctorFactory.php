<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Doctor::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->imageUrl(50, 50),
        'title' => $faker->word,
        'desc' => $faker->sentence,
        'department_id' => function () {
            return factory('App\Models\Department')->create()->id;
        },
        'status' => 1,
    ];
});
