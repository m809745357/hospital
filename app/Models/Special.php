<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/specials/' . $this->id;
    }
}
