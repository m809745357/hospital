<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Nurse::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'avatar' => $faker->imageUrl(200, 200),
        'secret' => '123456',
        'money' => 0,
        'order_num' => 0
    ];
});
