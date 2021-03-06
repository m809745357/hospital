<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const ROLES = ['normal', 'promoter'];

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
     * 用户可以成为推广人
     */
    public function promoter()
    {
        return $this->hasOne(Models\Promoter::class, 'user_id');
    }

    public function promoterOrder()
    {
        return $this->hasMany(Models\PromoterOrder::class, 'user_id');
    }

    /**
     * 成为推广人
     */
    public function addPromoter($promoter)
    {
        return $this->promoter()->create($promoter);
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

    public function order()
    {
        return $this->hasMany(Models\Order::class, 'user_id');
    }

    public function statistics()
    {
        return $this->hasMany(Models\PromoterRecordStatistics::class, 'user_id');
    }

    public function checkPrefect()
    {
        return $this->mobile === null;
    }

    public function checkAddress()
    {
        return $this->address === null || $this->address === '';
    }

    public function checkPromoter()
    {
        return $this->role === 'promoter';
    }
}
