<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheduling extends Model
{
    const TYPES = ['expert', 'general', 'famous'];

    const TYPES_DISPLAY = [
        'expert' => '专家门诊',
        'general' => '普通门诊',
        'famous' => '名医门诊',
    ];

    protected $guarded = [];

    public function getTypeAttribute($type)
    {
        return self::TYPES_DISPLAY[$type];
    }
}
