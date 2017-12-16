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
        return $this->order()->create($order);
    }
}
