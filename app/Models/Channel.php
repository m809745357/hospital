<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    public function food()
    {
        return $this->hasMany(Food::class, 'channel_id');
    }
}
