<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoterRecord extends Model
{
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::bootTraits();

        static::created(function ($query) {
            // $query->order->promoter->increment('crown', $query->crown);
            // $query->order->promoter->increment('stars', $query->stars);
        });
    }

    public function order()
    {
        return $this->belongsTo(PromoterOrder::class, 'promoter_order_id');
    }
}
