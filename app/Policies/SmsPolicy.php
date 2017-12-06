<?php

namespace App\Policies;

use App\User;
use App\Models\Sms;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the sms.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Sms  $sms
     * @return mixed
     */
    public function view(User $user, Sms $sms)
    {
        //
    }

    /**
     * Determine whether the user can create sms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the sms.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Sms  $sms
     * @return mixed
     */
    public function update(User $user, Sms $sms)
    {
        return $sms->user && $sms->isNotRead() && $sms->user->id === $user->id;
    }

    /**
     * Determine whether the user can delete the sms.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Sms  $sms
     * @return mixed
     */
    public function delete(User $user, Sms $sms)
    {
        //
    }
}
