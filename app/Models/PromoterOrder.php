<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoterOrder extends Model
{
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function record()
    {
        return $this->hasOne(PromoterRecord::class, 'promoter_order_id');
    }

    public function promoter()
    {
        return $this->belongsTo(promoter::class, 'promoter_id');
    }
}
