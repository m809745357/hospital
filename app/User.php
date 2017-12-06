<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 新增短信
     *
     * @param [type] $demand [description]
     */
    public function addSms($sms)
    {
        return $this->sms()->create($sms);
    }

    /**
     * 用户有很多短信
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sms()
    {
        return $this->hasMany(Models\Sms::class, 'user_id');
    }

    /**
     * 标记已读
     *
     * @return [type] [description]
     */
    public function markSmsAsRead()
    {
        return $this->sms->each->markAsRead();
    }

    public function mobileExists()
    {
        return \App\User::where('mobile', request()->mobile)->where('id', '<>', $this->id)->exists();
    }
}
