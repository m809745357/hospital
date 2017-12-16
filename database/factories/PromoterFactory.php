<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Promoter::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'hospital' => '诸暨市人民医院',
        'department' => '皮肤科',
        'job_title' => '职称',
        'crown' => 0,
        'stars' => 0
    ];
});
