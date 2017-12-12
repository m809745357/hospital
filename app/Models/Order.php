<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use EasyWeChat\Foundation\Application;

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
        return $this->attributes['order_details'] = unserialize($order_details);
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

    public function ipad()
    {
        $app = new Application(config('wechat'));
        $payment = $app->payment;

        $order = new \EasyWeChat\Payment\Order($this->getWechatOrder('NATIVE'));
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $code_url = $result->code_url;
            return $code_url;
        }
        return false;
    }

    public function getWechatOrder($trade_type)
    {
        return $attributes = [
            'trade_type' => $trade_type, // JSAPI，NATIVE，APP...
            'body' => '微信点餐',
            'detail' => '微信点餐',
            'out_trade_no' => $this->out_trade_no,
            'total_fee' => $this->money, // 单位：分
            'notify_url' => config('app.url') . '/wechat/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid' => auth()->user()->openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
    }
}
