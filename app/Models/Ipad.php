<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ipad extends Model
{
    protected $guarded = [];

    public function records()
    {
        return $this->hasMany(IpadRecord::class, 'ipad_id');
    }

    public function addIpadRecord($record)
    {
        return $this->records()->create($record);
    }
}
