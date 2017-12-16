<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $guarded = [];

    protected $appends = ['num'];

    const TYPES = ['am', 'pm', 'all'];

    protected function getNumAttribute($num)
    {
        return $num ?? 0;
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
