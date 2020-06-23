<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @param User $user
     * @param User $currentUser
     * @return bool
     */
    public function edit($user, User $currentUser)
    {
        return $user->id == $currentUser->id;
    }
}
