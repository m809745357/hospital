<?php

use Faker\Generator as Faker;
use App\Models\Scheduling;

$factory->define(Scheduling::class, function (Faker $faker) {
    $type = Scheduling::TYPES;

    return [
        'doctor_id' => function () {
            return factory('App\Models\Doctor')->create()->id;
        },
        'type' => $type[rand(0, 2)],
        'day' => rand(1, 7),
        'time' => rand(1, 3),
        'address' => $faker->word,
        'money' => $faker->randomNumber(2),
    ];
});
