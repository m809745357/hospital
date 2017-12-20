<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Physical::class, function (Faker $faker) {
    return [
        'department_id' => function () {
            return factory('App\Models\Department')->create()->id;
        },
        'title' => $faker->sentence,
        'image' => $faker->imageUrl(200, 200),
        'desc' => $faker->sentence,
        'money' => $faker->randomNumber(2),
    ];
});
