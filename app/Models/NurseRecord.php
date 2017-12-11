<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseRecord extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        static::bootTraits();

        static::created(function ($query) {
            $query->nurse->increment('money', $query->order->money);
        });
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class, 'nurse_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
