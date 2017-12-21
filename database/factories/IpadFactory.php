<?php

use Faker\Generator as Faker;
use App\Models\Ipad;

$factory->define(Ipad::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'remark' => $faker->paragraph,
        'address' => $faker->address,
        'money' => 0,
        'order_num' => 0,
        'status' => 1
    ];
});
