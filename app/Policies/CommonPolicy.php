<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class CommonPolicy
{
    protected const ROLE_SUPER_ADMIN = 'super-admin';

    /**
     * All actions allowed for super admin
     *
     * @param User $user
     * @return mixed
     */
    public function before(User $user)
    {
        return $user->hasRole(self::ROLE_SUPER_ADMIN)
            ? true
            : null
        ;
    }
}
