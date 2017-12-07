<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $guarded = [];

    protected $appends = ['num'];

    const TYPES = ['am', 'pm', 'all'];

    protected function getNumAttribute()
    {
        return '0';
    }
}
