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

    public function ipadRecord()
    {
        return $this->hasOne(IpadRecord::class, 'id', 'order_id');
    }

    public function getOrderDetailsAttribute($order_details)
    {
        return $this->attributes['order_details'] = is_array($order_details) ? $order_details : unserialize($order_details);
    }
}
