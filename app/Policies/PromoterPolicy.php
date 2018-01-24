<?php

namespace App\Policies;

use App\User;
use App\Models\Promoter;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromoterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the promoter.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Promoter  $promoter
     * @return mixed
     */
    public function view(User $user, Promoter $promoter)
    {
        return $user->id !== $promoter->user_id;
    }

    /**
     * Determine whether the user can create promoters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Promoter $promoter)
    {
        return $user->id !== $promoter->user_id;
    }

    /**
     * Determine whether the user can update the promoter.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Promoter  $promoter
     * @return mixed
     */
    public function update(User $user, Promoter $promoter)
    {
        //
    }

    /**
     * Determine whether the user can delete the promoter.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Promoter  $promoter
     * @return mixed
     */
    public function delete(User $user, Promoter $promoter)
    {
        //
    }
}
