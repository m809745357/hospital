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
        'name' => $faker->name,
        'gender' => 'men',
        'mobile' => '18367831980'
    ];
});
