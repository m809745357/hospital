<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpadRecord extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        static::bootTraits();

        static::created(function ($query) {
            $query->ipad->increment('money', $query->order->money);
            $query->ipad->increment('order_num');
        });
    }

    public function ipad()
    {
        return $this->belongsTo(Ipad::class, 'ipad_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
