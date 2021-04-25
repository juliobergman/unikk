<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;
use App\Models\Membership;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembershipPolicy
{
    use HandlesAuthorization;

    public function setDefault(User $user, Membership $membership)
    {
        return $user->id === $membership->user_id
                ? Response::allow('Success')
                : Response::deny('Denied');

    }

}
