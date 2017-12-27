<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promoter extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/promoter/{$this->id}";
    }

    public function order()
    {
        return $this->hasMany(PromoterOrder::class, 'promoter_id');
    }

    public function addOrder($order)
    {
        $order['order_no'] = date('YmdHis') . rand(1000, 9999);
        $order['user_id'] = auth()->id();

        return $this->order()->create($order);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function admin_user()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }
}
