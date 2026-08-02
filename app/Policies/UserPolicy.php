<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function admin(User $user): Response
    {
        return $user->role === 'admin' ? Response::allow() : Response::deny('hanya admin yang dapat melakukan tindakan ini!');
    }
}
