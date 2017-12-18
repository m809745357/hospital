<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 未支付，已支付，已配送/已兑换，已完成，已取消
    const STATUS = ['1', '2', '3', '4', '5'];

    const PAY_WAYS = ['wechat', 'card', 'ipad'];

    // const ORDER_TYPES = ['parcels', '']

    protected $guarded = [];

    public function path()
    {
        return "/orders/{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function getOrderDetailsAttribute($order_details)
    {
        return $this->attributes['order_details'] = is_array($order_details) ? $order_details : unserialize($order_details);
    }

    public function wechat()
    {
        $app = new Application(config('wechat'));
        $payment = $app->payment;

        $order = new \EasyWeChat\Payment\Order($this->getWechatOrder('JSAPI'));
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $prepayId = $result->prepay_id;
            return $payment->configForJSSDKPayment($prepayId);
        }
        return false;
    }
}
