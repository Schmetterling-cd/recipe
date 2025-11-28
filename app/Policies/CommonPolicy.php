<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class CommonPolicy
{
    /**
     * All actions allowed for super admin
     *
     * @param User $user
     * @return mixed
     */
    public function before(User $user)
    {
        return $user->hasRole(User::ROLE_SUPER_ADMIN)
            ? true
            : null
        ;
    }
}
