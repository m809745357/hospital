<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dynamic extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/dynamics/' . $this->id;
    }
}
