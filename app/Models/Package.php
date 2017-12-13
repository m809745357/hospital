<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    protected $appends = ['num'];

    protected function getNumAttribute($num)
    {
        return $num ?? 0;
    }
}
