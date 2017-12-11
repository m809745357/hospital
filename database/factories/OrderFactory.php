<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    $food = factory('App\Models\Food')->create()->toArray();
    $food['num'] = 5;
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'money' => $food['money'] * $food['num'],
        'out_trade_no' => config('wechat.payment.merchant_id') . date('YmdHis') . rand(1000, 9999),
        'foods' => serialize($food),
        'order_time' => '',
        'remark' => 'am'
    ];
});
