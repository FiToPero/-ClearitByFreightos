<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    public function user(User $user): bool
    {
        return $user->role->hasPermission('user');
    }

    public function agent(User $user): bool
    {
        return $user->role->hasPermission('agent');
    }
}
