<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Physical extends Model
{
    protected $guarded = [];

    protected $appends = ['num'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    protected function getNumAttribute($num)
    {
        return $num ?? 0;
    }
}
