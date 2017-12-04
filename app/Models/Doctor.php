<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function schedulings()
    {
        return $this->hasMany(Scheduling::class, 'doctor_id');
    }
}
