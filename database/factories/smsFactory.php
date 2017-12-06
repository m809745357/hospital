<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Sms::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'mobile' => '18367831980',
        'code' => '666666',
        'read_at' => null
    ];
});
