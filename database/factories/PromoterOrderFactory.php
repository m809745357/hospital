<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PromoterOrder::class, function (Faker $faker) {
    return [
        'department_id' => function () {
            return factory('App\Models\Department')->create()->id;
        },
        'promoter_id' => function () {
            return factory('App\Models\Promoter')->create()->id;
        },
        'order_no' => date('YmdHis') . rand(1000, 9999),
        'name' => $faker->name,
        'gender' => 'men',
        'mobile' => '18367831980'
    ];
});
