<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function physical()
    {
        return $this->hasMany(Physical::class, 'department_id');
    }
}
