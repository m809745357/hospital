<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sms extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'mobile';
    }

    public function path()
    {
        return "/sms/{$this->mobile}";
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * 判断验证码是否相同
     *
     * @return [type] [description]
     */
    public function validateMobile()
    {
        $now = Carbon::now('Asia/Shanghai');
        $codeTime = Carbon::parse($this->created_at, 'Asia/Shanghai')->addSeconds(30 * 60);

        if (request()->code != $this->code) {
            return false;
        }

        $this->markAsRead();
        if ($now->gt($codeTime)) {
            return false;
        }
        return true;
    }

    public function isNotRead()
    {
        return $this->read_at === null;
    }
}
