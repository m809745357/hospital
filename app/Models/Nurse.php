<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/nurses/' . $this->id;
    }

    public function records()
    {
        return $this->hasMany(NurseRecord::class, 'nurse_id');
    }

    public function addOrderRecord($record)
    {
        return $this->records()->create($record);
    }
}
